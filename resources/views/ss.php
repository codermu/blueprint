<?php

public function update(Request $request){
  
  //dapatkan id user
  $id_admin = Auth::user()->id;
  
  // queery ke database Where id = $id_admin
  $data_admin = User::where('id','=',$id_admin)->first();

  // Check  password baru dengan password lama
        if (Hash::check($request->password,$data_admin->password)) {
            Session::flash('err_msg','Password Baru tidak boleh sama dengan Password Lama');
            return Redirect::to('/change-password');
        }

        if ($request->password_baru != $request->konfirmasi_password) {
          return Redirect::to('/change-password');
        }

        // Cek Password Lama benar apa tidak
        if (Hash::check($request->password_lama,$data_admin->password)) {
             
             // update password baru ke table user
            User::where('id','=',$id_admin)->update([
                'password' => bcrypt($request->password)
            ]);

            // setelah sukses Logout
            Auth::logout();


            Session::flash('sc_msg','Berhasil Mengganti Password, Silahkan Login untuk Melanjutkan');
            return Redirect::to('/login');
        }
        else{
            Session::flash('err_msg','Passwod Lama Salah');
            return Redirect::to('/change-password');
        }
}