package com.test.venteonline;

import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.GridView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.android.volley.Response;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ProfilsFragment extends Fragment {
    private int userId = -1;
    private TextView id, name, username, email;

    private String url = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidViewUserController.php";
    private String urlProduct = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidProductUserController.php";

    public ProfilsFragment(){
        super(R.layout.fragment_profil);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        id = view.findViewById(R.id.id_value);
        name = view.findViewById(R.id.name);
        username = view.findViewById(R.id.username);
        email = view.findViewById(R.id.email);

        userId = getArguments().getInt("USER_ID", -1);
        if (userId != -1) {
            id.setText(String.valueOf(userId));
            loadUserData();
        } else {
            Toast.makeText(getContext(), "ID utilisateur non valide", Toast.LENGTH_SHORT).show();
        }

        GridView gridView = view.findViewById(R.id.list);
        List<Product> productList = new ArrayList<>();
        ProductAdapter adapter = new ProductAdapter(getContext(), productList);
        gridView.setAdapter(adapter);

        RequestQueue queue = Volley.newRequestQueue(getContext());

        Toast.makeText(getContext(), "Chargement des produits...", Toast.LENGTH_SHORT).show();

        JSONObject productRequest = new JSONObject();
        try {
            productRequest.put("user_id", userId);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, urlProduct,productRequest, new Response.Listener<JSONObject>() {

            @Override
            public void onResponse(JSONObject response) {
                try {
                    Log.d("ProfilsFragment", "Réponse complète: " + response.toString());
                    if (response.has("products")) {
                        JSONArray productsArray = response.getJSONArray("products");

                        for (int i = 0; i < productsArray.length(); i++) {
                            JSONObject p = productsArray.getJSONObject(i);

                            String id = p.getString("idProd");
                            String title = p.getString("title");
                            String desc = p.getString("description");
                            double price = p.getDouble("price");
                            String imageUrl = p.getString("image");

                            String baseImageUrl = "http://192.168.1.253/NirInfo/venteOnline/public/images/";
                            Uri imageUri;

                            if (imageUrl != null && (imageUrl.endsWith(".jpg") || imageUrl.endsWith(".jpeg") || imageUrl.endsWith(".png"))) {
                                imageUri = Uri.parse(baseImageUrl + imageUrl);
                            } else {
                                imageUri = Uri.parse("data:image/jpeg;base64," + imageUrl);
                            }

                            Product product = new Product(id, title, desc, price, imageUri);
                            productList.add(product);
                        }
                        adapter.notifyDataSetChanged();
                        Toast.makeText(getContext(), "Produits chargés", Toast.LENGTH_SHORT).show();

                    } else {
                        Log.e("ProfilsFragment", "La clé 'products' n'existe pas dans la réponse");
                        Toast.makeText(getContext(), "Format de réponse incorrect", Toast.LENGTH_LONG).show();
                    }


                }catch (JSONException e){
                    Log.e("ProfilsFragment", "Erreur JSON: " + e.getMessage());
                    Toast.makeText(getContext(), "Erreur de traitement des données: " + e.getMessage(), Toast.LENGTH_LONG).show();
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener(){
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("ProfilsFragment", "Erreur Volley: " + error.toString());
                Toast.makeText(getContext(), "Erreur de connexion: " + error.getMessage(), Toast.LENGTH_LONG).show();
                error.printStackTrace();
            }
        });
        queue.add(jsonObjectRequest);
    }

    private void loadUserData() {
        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("user_id", userId);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, url, jsonObject,
                response -> {
                    try {
                        boolean success = response.getBoolean("success");
                        if (success) {
                            JSONObject user = response.getJSONObject("user");
                            name.setText(user.getString("name"));
                            username.setText(user.getString("username"));
                            email.setText(user.getString("email"));
                        } else {
                            String message = response.getString("message");
                            Toast.makeText(getContext(), message, Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(getContext(), "Erreur lors du traitement des données", Toast.LENGTH_SHORT).show();
                    }
                },
                error -> {
                    if (error.networkResponse != null) {
                        Log.e("Erreur réseau", "Code: " + error.networkResponse.statusCode);
                    } else {
                        Log.e("Erreur Volley", error.toString());
                    }
                    Toast.makeText(getContext(), "Erreur de connexion au serveur", Toast.LENGTH_SHORT).show();
                }
        );

        queue.add(request);
    }

}
