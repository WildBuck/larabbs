<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;

use Illuminate\Http\Request;
use App\Models\User;

use App\Handlers\ImageUploadhandler;

class UsersController extends Controller
{
    //
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();


        if($request->avatar){
            $result = ImageUploadHandler::save($request->avatar,'avatars',$user->id,362);
            if($result){//这里是ImageUploaderHandler对文件后缀名做了限定
                $data['avatar'] = $result['path'];
            }
        }


        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
