package com.test.venteonline;

import android.net.Uri;

public class Product {
        private String id;
        private String title;
        private String description;
        private double price;
        private Uri imageUri;



        public Product(String id, String title, String description, double price, Uri imageUri) {
            this.id = id;
            this.title = title;
            this.description = description;
            this.price = price;
            this.imageUri = imageUri;
        }

        // Getters et Setters
        public String getId() {
            return id;
        }

        public void setId(String id) {
            this.id = id;
        }

        public String getTitle() {
            return title;
        }

        public void setTitle(String title) {
            this.title = title;
        }

        public String getDescription() {
            return description;
        }

        public void setDescription(String description) {
            this.description = description;
        }

        public double getPrice() {
            return price;
        }

        public void setPrice(double price) {
            this.price = price;
        }

        public Uri getImageUri() {
            return imageUri;
        }

        public void setImageUri(Uri imageUri) {
            this.imageUri = imageUri;
        }
}
