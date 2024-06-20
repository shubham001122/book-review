<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;

use Illuminate\Http\Request;

class BookController extends Controller
{
    
public function index()
{

    $user = Auth::user();
$list = Book::get();   
return view('book.list',[
 'user' => $user ,
 'book_list' => $list

]);

}

public function create()
{

    $user = Auth::user();
    return view('book.create',[
     'user' => $user  
   
    ]);
}

public function store(Request $request)
{

$title = $request->title;
$author = $request->author;
$description = $request->description;
$image = $request->image;
$status = $request->status;

$validator = Validator::make($request->all(),[

'title' => 'required|min:8' ,
'author' => 'required|min:4' ,
'description' => 'required' ,
'image' => 'required|image' ,
 

]);

if($validator->fails())
{

return redirect()->route('books.create')
->withErrors($validator)->withInput($request->all());

}


$img_ext =  $image->getClientOriginalExtension();
$img_name = time().'.'.$img_ext;
$image->move(public_path('uploads/books'),$img_name);


$book = new Book();
$book->title = $title;
$book->author = $author;
$book->description = $description;
$book->image = $img_name;
//$book->status = $status;
$book->save();





return redirect()->route('books.create')
->with('create',"Book created successfully");


}

public function editBook(Request $request)
{

$user = Auth::user();    
$id = $request->id;
$book = Book::where('id',$id)->first();



return view('book.editbook',[

    'book' => $book ,
    'user' => $user
]);


}

public function updateBook($id,Request $request)
{

$rules = 
[
'title'  => 'required' ,
'author' => 'required'  ,
'description' => 'required'     
];

$validator =  Validator::make($request->all(),$rules);

if($validator->fails())
{

return redirect()->route('books.editBook',$id)
->withErrors($validator);

}

$book = Book::find($id);
$book->title = $request->title;
$book->save();

return redirect()->route('books.index')
->with('edited','Book updated successfully');

}

public function deleteBook(Request $request)
{

    $book = Book::find($request->id);
    $book->delete();

session()->flash('deleted','Book deleted successfully');

    return response()->json([
    'status' => true 
     ]);



}

}
