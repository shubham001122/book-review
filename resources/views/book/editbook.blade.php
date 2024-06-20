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
                    <div class="card-header  text-white">
                        Edit Book
                    </div>
                    <form action="{{ route('books.updateBook',$book->id) }}" method="post">
                    @csrf
                        <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input value="{{ $book->title }}" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" />
                        
                            @error('title')
                            <p class = "invalid-feedback"> {{ $message }} </p>
                            @enderror
                        
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input value="{{ $book->author }}" type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author"/>
                           
                            @error('author')
                            <p class = "invalid-feedback"> {{ $message }} </p>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" cols="30" rows="5">{{ $book->description }}</textarea>
                        
                            @error('description')
                            <p class = "invalid-feedback"> {{ $message }} </p>
                            @enderror    
                        
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control"  name="image" id="image"/>
                           
                           

                            <br>
                            <img src="{{ asset('uploads/books/'.$book->image) }}" alt="" class="w-25">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Active</option>
                                <option value="">Block</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3">Update</button>                     
                    </div>
                    <form>
                </div>                
            </div>


            
        </div>       
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
</body>
</html>



@endsection