<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart
{
    public static function all()
    {
        return is_null(Session::get('cart')) ? [] : Session::get('cart');
    }

    public function whereExist($productId)
    {
        $cart = is_null(Session::get('cart')) ? [] : Session::get('cart');
        $status = false;
        if(empty($cart)){
            return $status;
        }

        foreach($cart as $item){
            if($item['product']['id'] !== $productId){
                $status = true;
                break;
            }
        }

        return $status;
    }

    public function create($data)
    {
        $cart = is_null(Session::get('cart')) ? [] : Session::get('cart');
        $id = count($cart) + 1;
        $new_data = $cart;
        $data['id'] = $id;
        $new_data[$id - 1] = $data;
        Session::put('cart', $new_data);

        return $new_data;
    }

    public function delete($id)
    {
        $cart = is_null(Session::get('cart')) ? [] : Session::get('cart');
        if(count($cart) == 0){
            return null;
        }
        $index = 0;
        foreach ($cart as $i => $item) {
            if($item['id'] == $id){
                $index = $i;
            }
        }
        unset($cart[$index]);
        $new_entry = [];
        $no = 1;
        foreach ($cart as $item) {
            $entry = $item;
            $entry['id'] = $no;
            $no++;
            $new_entry[] = $entry;
        }

        Session::put('cart',$new_entry);
        return true;
    }

    public function destroy()
    {
        Session::put('cart',[]);
        return true;
    }
}
