package com.test.venteonline;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import androidx.appcompat.app.AppCompatActivity;

public class ValidationActivity extends AppCompatActivity {
    private Button buttonLogin;
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.validation_activity);


        buttonLogin = findViewById(R.id.buttonLogin);

        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ValidationActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }

}
