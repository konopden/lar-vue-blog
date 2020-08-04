<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->to('/user/' . Auth::user()->id);
        }

        return redirect()->to(app()->getLocale() . '/login');
    }

    public function show($lang, $id)
    {
        $user = $this->user->getById($id);

        if (!isset($user)) abort(404);

        $comments = $user->comments->take(10);

        return view('user.index', compact('user', 'comments'));
    }

    public function edit()
    {
        if (!\Auth::id()) abort(404);

        $user = $this->user->getById(\Auth::id());

        return view('user.profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cropAvatar(Request $request)
    {
        $currentImage = $request->get('image');
        $data = $request->get('data');

        $image = Image::make($currentImage['fullPath']);

        $image->crop((int)$data['width'], (int)$data['height'], (int)$data['x'], (int)$data['y']);

        $image->save($currentImage['fullPath']);

        $this->user->saveAvatar(auth()->user()->id, $currentImage['webPath']);

        return response()->json($currentImage);
    }

    public function update(Request $request, $lang, $id){
        $input = $request->except(['name', 'email', 'is_admin']);

        $user = $this->user->getById($id);

        $this->authorize('update', $user);

        $this->user->update($id, $input);

        return redirect()->back();
    }
}
