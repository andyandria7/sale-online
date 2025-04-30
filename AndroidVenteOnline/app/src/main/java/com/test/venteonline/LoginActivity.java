    package com.test.venteonline;

    import android.annotation.SuppressLint;
    import android.os.Bundle;

    import androidx.appcompat.app.AppCompatActivity;
    import androidx.fragment.app.Fragment;

    import com.google.android.material.bottomnavigation.BottomNavigationView;

    public class LoginActivity extends AppCompatActivity {
        private int userId;
        private BottomNavigationView bottomNavigationView;
        @SuppressLint("NonConstantResourceId")
        @Override
        protected void onCreate(Bundle savedInstanceState){
            super.onCreate(savedInstanceState);
            setContentView(R.layout.activity_main);

            bottomNavigationView = findViewById(R.id.bottom_navigation);

            bottomNavigationView.setElevation(8f);
            userId = getIntent().getIntExtra("USER_ID", -1);

            bottomNavigationView.setOnNavigationItemSelectedListener(item -> {
                Fragment selectedFragment = null;
                int itemId = item.getItemId();


                if (itemId == R.id.home) {
                    selectedFragment = new HomeFragment();
                } else if (itemId == R.id.vue) {
                    CreateFragment createFragment = new CreateFragment();
                    Bundle bundle = new Bundle();
                    bundle.putInt("USER_ID", userId);
                    createFragment.setArguments(bundle);
                    selectedFragment = createFragment;

                } else if (itemId == R.id.profils) {
//                    selectedFragment = new ProfilsFragment();
                    ProfilsFragment profils = new ProfilsFragment();
                    Bundle bundle = new Bundle();
                    bundle.putInt("USER_ID", userId);
                    profils.setArguments(bundle);
                    selectedFragment = profils;
                }

                if (selectedFragment != null) {
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_container, selectedFragment)
                            .commit();
                }

                return true;
            });
            if (savedInstanceState == null) {
                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, new HomeFragment())
                        .commit();
            }
        }
    }
