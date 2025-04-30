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
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class MainActivity extends AppCompatActivity {

    private EditText email, password;
    private Button buttonLogin, buttonRegister;
    private CheckBox checkBoxShowPassword;

    private String url = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidLoginController.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
//        setContentView(R.layout.activity_main);
        setContentView(R.layout.login_activity);

        email = findViewById(R.id.email);
        password = findViewById(R.id.password);
        buttonLogin = findViewById(R.id.buttonLogin);
        buttonRegister = findViewById(R.id.buttonRegister);
        checkBoxShowPassword = findViewById(R.id.checkBoxShowPassword);

        buttonLogin.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                loginUser();
            }
        });

        checkBoxShowPassword.setOnCheckedChangeListener((buttonView, isChecked) -> {
            if (isChecked) {
                password.setInputType(144); // Afficher le texte
            } else {
                password.setInputType(129); // Masquer le texte
            }
        });

        buttonRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, RegisterActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }

    private void loginUser() {
        String loginEmail = email.getText().toString().trim();
        String loginPass = password.getText().toString().trim();

//        Login login = new Login();
//        String loginEmail = login.getEmail();
//        String loginPass = login.getPassword();


        if (loginEmail.isEmpty() || loginPass.isEmpty()) {
            Toast.makeText(this, "Veuillez remplir tous les champs", Toast.LENGTH_LONG).show();
            return;
        }
        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("email", loginEmail);
            jsonObject.put("password", loginPass);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            public void onResponse(String response) {

                // Traitement de la réponse du serveur
                try {
                    JSONObject jsonResponse = new JSONObject(response);
                    boolean success = jsonResponse.getBoolean("success");
                    if (success) {
                        Toast.makeText(MainActivity.this, "Connexion réussie!", Toast.LENGTH_SHORT).show();

                        JSONObject user = jsonResponse.getJSONObject("user");


                        int isApproved = user.getInt("is_approved");
                        int userId = user.getInt("id");
                        if (isApproved == 1) {

                            Toast.makeText(MainActivity.this, "Votre compte est validé!", Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(MainActivity.this, LoginActivity.class);
                            intent.putExtra("USER_ID", userId);
                            startActivity(intent);
                            finish();

                        } else {
                            Toast.makeText(MainActivity.this, "Votre compte n'est pas encore validé!", Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(MainActivity.this, ValidationActivity.class);
                            startActivity(intent);
                            finish();
                        }
                    } else {
                        Toast.makeText(MainActivity.this, "Échec de connexion!", Toast.LENGTH_SHORT).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    Log.e("JSON Error", response);
                    Toast.makeText(MainActivity.this, "Erreur JSON!!!!!!!!!!!!!!!!!!", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            public void onErrorResponse(VolleyError error) {
                // Gestion des erreurs
                if (error.networkResponse != null) {
                    Log.e("Erreur de connexion", "Code: " + error.networkResponse.statusCode);
                } else {
                    Log.e("Erreur Volley", error.toString());
                }
            }
        }) {
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