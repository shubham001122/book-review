@extends('layouts.app')

@section('main')

<div class="container">
    <div class="row my-5">
      
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome, {{ $user->name  }}                       
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ asset('uploads/profile/'.Auth::user()->image) }}" width="150" height="150" class="img-fluid rounded-circle">                            
                    </div>
                    <div class="h5 text-center">
                        <strong>{{ $user->name  }} </strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header  text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('books.index') }}">Books</a>                               
                        </li>
                        <li class="nav-item">
                            <a href="reviews.html">Reviews</a>                               
                        </li>
                        <li class="nav-item">
                            <a href="profile.html">Profile</a>                               
                        </li>
                        <li class="nav-item">
                            <a href="my-reviews.html">My Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="change-password.html">Change Password</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('account.logout') }}">Logout</a>
                        </li>                           
                    </ul>
                </div>
            </div>
        </div>
    
       

        <div class="col-md-9">
           <div class="card border-0 shadow">

            @if(Session::has('edited'))
            <div class = "alert alert-success">{{ Session::get('edited') }}</div> 
                @endif

                @if(Session::has('deleted'))
                <div class = "alert alert-success">{{ Session::get('deleted') }}</div> 
                    @endif    

                <div class="card-header  text-white">
                    Books
                </div>
                <div class="card-body pb-0">            
                    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>            
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                            <tbody>

                            @foreach ($book_list as $item)
                               
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->author }}</td>
                                <td>3.0 (3 Reviews)</td>
                                <td>Active</td>
                                <form method="post" action="">
                                    @csrf
                                <td>
                                    <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                    <a href="{{ route('books.editBook',$item->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a onclick="ok({{ $item->id }})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </form>
                            </tr>
                     
                       @endforeach    
                        </tbody>  
                        </thead>
                    </table>   
                    <nav aria-label="Page navigation " >
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                      </nav>                  
                </div>
                
            </div>   
                   
            
        </div>
   
    </div>       
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">


function ok(id)
{

if(confirm("Do you want to delete this book ?"))
{

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$.ajax({
    type: "post",
    url: "{{ route('books.deleteBook') }}",
    data: {id: id},
    dataType: "json",
  success: function (response) {
 
if(response.status)
{

window.location.href = "{{ route('books.index') }}"; 

}

  }

});



}


}
</script>


@endsection