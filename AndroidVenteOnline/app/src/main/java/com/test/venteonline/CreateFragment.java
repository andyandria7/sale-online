package com.test.venteonline;

import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.OpenableColumns;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;

public class CreateFragment extends Fragment {
    private Button btnImage;
    private EditText etTitle;
    private TextView tvNoFile;
    private EditText etDescription;
    private EditText etPrice;
    private Button btnSubmit;
    private Uri selectedImageUri;
    private int userId = -1;
    Fragment selectedFragment = null;

    private String url = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidCreateController.php";


    public CreateFragment(){
        super(R.layout.fragment_create);
    }

   @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
       super.onViewCreated(view, savedInstanceState);
       btnImage = view.findViewById(R.id.btnImage);
       tvNoFile = view.findViewById(R.id.tvNoFile);
       etTitle = view.findViewById(R.id.etTitle);
       etDescription = view.findViewById(R.id.etDescription);
       etPrice = view.findViewById(R.id.etPrice);
       btnSubmit = view.findViewById(R.id.btnSubmit);
       if (getArguments() != null) {
           userId = getArguments().getInt("USER_ID", -1);
       }

       btnImage.setOnClickListener(v -> {
           Intent intent = new Intent(Intent.ACTION_GET_CONTENT);
           intent.setType("image/*");
           startActivityForResult(intent, 1);
       });

       btnSubmit.setOnClickListener(new View.OnClickListener() {
           @Override
           public void onClick(View v) {
               create();
           }
       });
   }
    private String encodeImageToBase64(Uri imageUri) {
        try {
            InputStream inputStream = requireContext().getContentResolver().openInputStream(imageUri);
            Bitmap bitmap = BitmapFactory.decodeStream(inputStream);

            // Réduction de la taille
            int maxSize = 800; // max 800px
            int width = bitmap.getWidth();
            int height = bitmap.getHeight();
            float ratio = (float) width / height;

            if (ratio > 1) {
                width = maxSize;
                height = (int) (width / ratio);
            } else {
                height = maxSize;
                width = (int) (height * ratio);
            }

            Bitmap resizedBitmap = Bitmap.createScaledBitmap(bitmap, width, height, true);

            ByteArrayOutputStream out = new ByteArrayOutputStream();
            resizedBitmap.compress(Bitmap.CompressFormat.JPEG, 50, out); // Compression à 80% pour alléger encore

            byte[] imageBytes = out.toByteArray();
            return Base64.encodeToString(imageBytes, Base64.DEFAULT);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }


    private String getFileNameFromUri(Uri uri) {
        String result = null;
        if (uri.getScheme().equals("content")) {
            try (Cursor cursor = requireContext().getContentResolver().query(uri, null, null, null, null)) {
                if (cursor != null && cursor.moveToFirst()) {
                    result = cursor.getString(cursor.getColumnIndexOrThrow(OpenableColumns.DISPLAY_NAME));
                }
            }
        }
        if (result == null) {
            result = uri.getLastPathSegment();
        }
        return result;
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == 1 && resultCode == getActivity().RESULT_OK && data != null) {
            selectedImageUri = data.getData();
            tvNoFile.setText("Image sélectionnée");
        }
    }


    private void create() {
        String base64Image = encodeImageToBase64(selectedImageUri);

        if (base64Image == null) {
            Toast.makeText(getContext(), "Erreur de conversion de l'image", Toast.LENGTH_LONG).show();
            return;
        }
        if (userId == -1) {
            Toast.makeText(getContext(), "Utilisateur non connecté", Toast.LENGTH_SHORT).show();
            return;
        }

        if (selectedImageUri == null) {
            Toast.makeText(getContext(), "Veuillez sélectionner une image", Toast.LENGTH_LONG).show();
            return;
        }

        String titre = etTitle.getText().toString().trim();
        String description = etDescription.getText().toString().trim();
        String price = etPrice.getText().toString().trim();

        if (titre.isEmpty() || description.isEmpty() || price.isEmpty()) {
            Toast.makeText(getContext(), "Veuillez remplir tous les champs", Toast.LENGTH_LONG).show();
            return;
        }

        // 🔥 On récupère le nom du fichier image
        String imageName = getFileNameFromUri(selectedImageUri);
        if (imageName == null) {
            Toast.makeText(getContext(), "Erreur pour récupérer le nom de l'image", Toast.LENGTH_LONG).show();
            return;
        }

        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("image", base64Image);
            jsonObject.put("title", titre);
            jsonObject.put("description", description);
            jsonObject.put("price", price);
            jsonObject.put("user_id", userId);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            public void onResponse(String response) {
                Toast.makeText(getContext(), "Création réussie!", Toast.LENGTH_LONG).show();
                etTitle.setText("");
                etDescription.setText("");
                etPrice.setText("");
                tvNoFile.setText("Aucun fichier choisi");
                selectedFragment = new HomeFragment();
                requireActivity().getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, selectedFragment)
                        .commit();
            }
        }, new Response.ErrorListener() {
            public void onErrorResponse(VolleyError error) {
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
