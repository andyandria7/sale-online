package com.test.venteonline;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.squareup.picasso.Callback;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class ProductAdapter extends BaseAdapter {
    private Context con;
    private List<Product> lp = new ArrayList<>();
    private LayoutInflater inflater;

    public ProductAdapter(Context con, List<Product> lp) {
        this.lp = lp;
        this.con = con;
        inflater = LayoutInflater.from(con);
    }
    @Override
    public int getCount() {
        return this.lp.size();
    }

    @Override
    public Object getItem(int position) {
        return this.lp.get(position);
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.adapter_item, null);
            holder = new ViewHolder();
            holder.image = convertView.findViewById(R.id.image);
            holder.titre = convertView.findViewById(R.id.titre);
            holder.desc = convertView.findViewById(R.id.desc);
            holder.price = convertView.findViewById(R.id.price);
            convertView.setTag(holder);
        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        Product p = (Product) getItem(position);
        String itemTitle = p.getTitle();
        String itemDesc = p.getDescription();
        double itemPrice = p.getPrice();
        Uri itemImage = p.getImageUri();

        holder.titre.setText(itemTitle);
        holder.desc.setText(itemDesc);
        holder.price.setText(String.valueOf(itemPrice) + " Ar");
        String baseUrl = "http://192.168.1.253/NirInfo/venteOnline/public/images/";

        if (itemImage.toString().startsWith("base64://")) {
            try {
                String base64Data = itemImage.toString().substring("base64://".length());
                byte[] decodedString = android.util.Base64.decode(base64Data, android.util.Base64.DEFAULT);
                Bitmap decodedByte = BitmapFactory.decodeByteArray(decodedString, 0, decodedString.length);
                holder.image.setImageBitmap(decodedByte);
            } catch (Exception e) {
                Toast.makeText(con, "Erreur image Base64: " + e.getMessage(), Toast.LENGTH_SHORT).show();
            }

        } else {
            String fullUrl = itemImage.toString();
            if (!fullUrl.startsWith("http")) {
                fullUrl = baseUrl + fullUrl;
            }

            Picasso.get()
                    .load(fullUrl)
                    .placeholder(R.drawable.placeholder_image)
                    .error(R.drawable.error_image)
                    .resize(300, 300)
                    .centerCrop()
                    .into(holder.image, new Callback() {
                        @Override
                        public void onSuccess() {}

                        @Override
                        public void onError(Exception e) {
                            Toast.makeText(con, "Erreur de chargement de l'image: " + e.getMessage(),
                                    Toast.LENGTH_SHORT).show();
                        }
                    });
        }

        return convertView;
    }


    private static class ViewHolder {
        ImageView image;
        TextView titre;
        TextView desc;
        TextView price;
    }
}