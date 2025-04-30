package com.test.venteonline;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;
import org.mindrot.jbcrypt.BCrypt;

import java.util.ArrayList;
import java.util.List;

public class RegisterActivity extends AppCompatActivity {
    private EditText name, username, email, password, passwordvalid;
    private Button buttonRegister, buttonCancel;
    private CheckBox checkBoxShowPassword, checkBoxShowPassword2;
    private String url = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidRegisterController.php";
    private List<Login> user = new ArrayList<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_register);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        name = findViewById(R.id.name);
        username = findViewById(R.id.username);
        email = findViewById(R.id.email);
        password = findViewById(R.id.password);
        passwordvalid = findViewById(R.id.passwordvalid);
        buttonRegister = findViewById(R.id.buttonRegister);
        buttonCancel = findViewById(R.id.buttonCancel);
        checkBoxShowPassword = findViewById(R.id.checkBoxShowPassword);
        checkBoxShowPassword2 = findViewById(R.id.checkBoxShowPassword2);

        buttonRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                registerUser();
            }
        });
        buttonCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(RegisterActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
        checkBoxShowPassword.setOnCheckedChangeListener((buttonView, isChecked) -> {
            if (isChecked) {
                password.setInputType(144); // Afficher le texte
            } else {
                password.setInputType(129); // Masquer le texte
            }
        });
        checkBoxShowPassword2.setOnCheckedChangeListener((buttonView, isChecked) -> {
            if (isChecked) {
                passwordvalid.setInputType(144); // Afficher le texte
            } else {
                passwordvalid.setInputType(129); // Masquer le texte
            }
        });
    }

    private void registerUser(){
        String nameRegister = name.getText().toString().trim();
        String usernameRegister = username.getText().toString().trim();
        String emailRegister = email.getText().toString().trim();
        String passwordRegister =  password.getText().toString().trim();
        String passwordvalidRegister = passwordvalid.getText().toString().trim();
        String hashed = BCrypt.hashpw(passwordRegister, BCrypt.gensalt());



        if(nameRegister.isEmpty() || usernameRegister.isEmpty() || emailRegister.isEmpty() || passwordRegister.isEmpty() || passwordvalidRegister.isEmpty()){
            Toast.makeText(this, "Veuillez remplir tous les champs", Toast.LENGTH_LONG).show();
            return;
        }

        JSONObject jsonObject = new JSONObject();
        for(Login login : user){
            if(login.getEmail().equals(emailRegister)){
                Toast.makeText(this, "Cet email est déjà utilisé", Toast.LENGTH_LONG).show();
                return;
            }
        }
        try {
            jsonObject.put("name", nameRegister);
            jsonObject.put("username", usernameRegister);
            jsonObject.put("email", emailRegister);
            jsonObject.put("password", hashed);
            jsonObject.put("passwordvalid", passwordvalidRegister);
        }catch (JSONException e) {
            e.printStackTrace();
        }
        RequestQueue queue = Volley.newRequestQueue(this);
         StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
             @Override
             public void onResponse(String response) {
                Toast.makeText(RegisterActivity.this, "Connexion", Toast.LENGTH_LONG).show();
                Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
                startActivity(intent);

             }
         }, new Response.ErrorListener() {
             @Override
             public void onErrorResponse(VolleyError error) {
                 if(error.networkResponse != null){
                     Log.e("Erreur de connexion", "Code: "+error.networkResponse.statusCode);
                 } else {
                     Log.e("Erreur Volley", error.toString());
                 }
             }
         }){
             @Override
             public byte[] getBody() {
                 return jsonObject.toString().getBytes();
             }

             @Override
             public String getBodyContentType() {
                 return "application/json";
             }
         };
        queue.add(request);
    }
}