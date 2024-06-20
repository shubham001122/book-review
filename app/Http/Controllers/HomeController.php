<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Review;

class HomeController extends Controller
{
    
public function index(Request $request)
{

$books =  Book::orderBy('created_at','DESC')->paginate(3);

if(empty($request->keyword) == false )
{

 $books =  Book::orderBy('created_at','DESC')
 ->where('title','like','%'.$request->keyword.'%')->paginate(3);

}

return view('home',[
    'books' => $books
])->withInput($request->keyword);


}

public function detail($id)
{

$book =  Book::where('id',$id)->first();

$randomBooks = Book::where('id','!=',$id)->inRandomOrder()
->take(3)->get();

return view('book-detail',
[
    'book' => $book ,
    'randomBooks' => $randomBooks
]);

}

public function saveReview(Request $request)
{


$rating = $request->rating;


$validator = Validator::make($request->all(),[

   'review' => 'required|min:10' ,
   'rating' => 'required'      
    
    ]);


if($validator->fails())
    {
        return response()->json([
            'status' => false ,
            'error' => $validator->errors()
             ]);
    
    }
    
else
{
    

$countReview = Review::where('user_id',Auth::user()->id)
->where('book_id', $request->book_id)
->count();

     if($countReview > 0 )
     {

        session()->flash("no_review","You already reviewed this book"); 
        
        return response()->json([
            'status' => true ,
            'error' => []
        ]); 

}

else
{

    $review = new Review();
    $review->review = $request->review;
    $review->rating = $rating;
    $review->user_id = Auth::user()->id;
    $review->book_id = $request->book_id;
    $review->save();
  
    session()->flash("review","Your Review is Submitted");

    return response()->json([
        'status' => true ,
        'error' => []
    ]);


   

}

}    


}

}
