package com.test.venteonline;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.GridView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class HomeFragment extends Fragment {
    private static final String TAG = "HomeFragment";
    private String url = "http://192.168.1.253/NirInfo/venteOnline/Controllers/AndroidShowController.php";

    public HomeFragment(){
        super(R.layout.fragment_home);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        GridView gridView = view.findViewById(R.id.list);
        List<Product> productList = new ArrayList<>();
        ProductAdapter adapter = new ProductAdapter(getContext(), productList);
        gridView.setAdapter(adapter);

        RequestQueue queue = Volley.newRequestQueue(getContext());

        Toast.makeText(getContext(), "Chargement des produits...", Toast.LENGTH_SHORT).show();

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(
                Request.Method.GET,
                url,
                null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            Log.d(TAG, "Réponse complète: " + response.toString());

                            if (response.has("products")) {
                                JSONArray products = response.getJSONArray("products");
                                Log.d(TAG, "Nombre de produits reçus: " + products.length());

                                for (int i = 0; i < products.length(); i++) {
                                    JSONObject p = products.getJSONObject(i);
                                    String id = p.getString("idProd");
                                    String title = p.getString("title");
                                    String desc = p.getString("description");
                                    double price = p.getDouble("price");
                                    String imageUrl = p.getString("image");

                                    String baseImageUrl = "http://192.168.1.253/NirInfo/venteOnline/public/images/";
                                    Uri imageUri;

                                    if (imageUrl != null && (imageUrl.endsWith(".jpg") || imageUrl.endsWith(".jpeg") || imageUrl.endsWith(".png"))) {
                                        // Si c'est une vraie URL d'image classique
                                        imageUri = Uri.parse(baseImageUrl + imageUrl);
                                    } else {
                                        // Sinon, on suppose que c'est du base64
                                        imageUri = Uri.parse("data:image/jpeg;base64," + imageUrl);
                                    }

                                    Product product = new Product(id, title, desc, price, imageUri);
                                    productList.add(product);
                                }

                                if (productList.isEmpty()) {
                                    Toast.makeText(getContext(), "Aucun produit trouvé", Toast.LENGTH_LONG).show();
                                } else {
                                    adapter.notifyDataSetChanged();
                                    Toast.makeText(getContext(), productList.size() + " produits chargés", Toast.LENGTH_SHORT).show();
                                }
                            } else {
                                Log.e(TAG, "La clé 'products' n'existe pas dans la réponse");
                                Toast.makeText(getContext(), "Format de réponse incorrect", Toast.LENGTH_LONG).show();
                            }
                        } catch (JSONException e) {
                            Log.e(TAG, "Erreur JSON: " + e.getMessage());
                            Toast.makeText(getContext(), "Erreur de traitement des données: " + e.getMessage(), Toast.LENGTH_LONG).show();
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e(TAG, "Erreur Volley: " + error.toString());
                        Toast.makeText(getContext(), "Erreur de connexion: " + error.getMessage(), Toast.LENGTH_LONG).show();
                        error.printStackTrace();
                    }
                });

        queue.add(jsonObjectRequest);
    }

}