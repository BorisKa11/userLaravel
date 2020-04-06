<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\User;

class ContactsController extends Controller
{
    private $userModel;
    
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items.*.name' => 'required|min:3',
            'items.*.email' => 'required|email|unique:users,email',
            'items.*.phone' => 'required'
        ], $messages = [
            'items.*.name.required' => 'Не введено имя',
            'items.*.name.min' => 'Имя должно содержать минимум 3 символа',
            'items.*.email.required' => 'Не введён email адрес',
            'items.*.email.email' => 'Неверный формат email адреса',
            'items.*.email.unique' => 'Данный email адрес занят',
            'items.*.phone.required' => 'Не введён телефон'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()->toArray()]);
        }
        $check = $this->checkValidate($request->items, $request->source_id);
        
        if ($check === false) {
            return response()->json(['status' => 0, 'errors' => 'Не удалось добавить пользователя...']);
        }
        
        return response()->json(['status' => 1, 'success' => $check]);
        
    }
    
    public function checkValidate($items, $source_id) {
        $ret = false;
        foreach($items as $item) {
            if (!$this->userModel->checkPhone($item['phone'], $source_id)) {
                $isAdded = $this->userModel->create([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'phone' => toDigits($item['phone']),
                    'password' => '123456',
                    'source_id' => (int)$source_id
                ]);
                
                if ($isAdded) {
                    $ret[] = 'Пользователь '.$item['name'].' добавлен';
                }
            }
        }
        return $ret;
    }
}
