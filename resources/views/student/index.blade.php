@extends('layouts.master')

@section('master_content')
 <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalLong">Add New Student+</button><br>
 <br>
<div class="card  mb-3">
  <div class="card-header text-white bg-secondary">Header</div>
  <div class="card-body">
    <h5 class="card-title">Secondary card title</h5>
   <table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">name</th>
      <th scope="col">roll</th>
      <th scope="col">image</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
  
   
  </tbody>
</table>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formdata" action="" method="post" enctype="multipart/form-data">
          @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="name" name="name" aria-describedby="" placeholder="Enter name">

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Roll</label>
    <input type="text" name="roll" class="form-control" id="roll" placeholder="Roll">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Image</label>
    <input type="file" id="image" name="image" class="form-control" id="">
  </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formdata2" action="" method="post" enctype="multipart/form-data">
          @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="name1" name="name" aria-describedby="" placeholder="Enter name">
    <input type="hidden" id="id"  name="id">

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Roll</label>
    <input type="text" name="roll" class="form-control" id="roll1" placeholder="Roll">
  </div>
  <div class="form-group" id="imageshow">
    <label for="exampleInputPassword1">Image</label>
    <input type="file" id="image" name="image1" class="form-control" id="">
  </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>












<script type="text/javascript">
  function studentalldata(){
    $.ajax({
      type:"GET",
      datatype:'json',
      url:"/student/create",
      success:function(response){
        rows="";
        $.each(response, function(key,value){
          rows+=` <tr>
      <th scope="row">${value.id}</th>
      <td>${value.name}</td>
      <td>${value.roll}</td>
      <td><img src="{{asset('student_images/${value.image}')}}" alt="" width="100"></td>
      <td><button type="button" class="btn btn-primary btn-sm" onclick="editdata(${value.id})" id="delete">edit/view</button>
      <button type="button" onclick=deletedata(${value.id}) class="btn btn-danger btn-sm" id="delete">delete</button></td>
    </tr> `
        })
        $('tbody').html(rows);

      }
    })
  }
  studentalldata();
</script>












<!-- script for store data -->
<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('submit','#formdata', function(e){
      e.preventDefault();
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  var formdata=new FormData($('#formdata')[0]);
$.ajax({
  type:"POST",
  data:formdata,
  contentType: false,
  processData: false,
  url:"/student",
  success:function(response){
    $('#exampleModalLong').modal('hide')
     studentalldata();
     $('#name').val('')
     $('#roll').val('')
     $('#image').val('')
  }

})
    })
  })
</script>



<script type="text/javascript">
  

</script>












<script type="text/javascript">
function deletedata(id){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
    type:"DELETE",
    dataType:"json",
    url:"/student/"+id,
    success:function(response){
      studentalldata();


    }
  })
}
</script>


<script type="text/javascript">
function editdata(id){

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
    type:"GET",
    dataType:"json",
    url:"/student/"+id+"/edit",
    success:function(response){
      $('#edit').modal('show')
      studentalldata();
      $('#name1').val(response.name)
      $('#roll1').val(response.roll)
      $('#id').val(response.id)

      $('#imageshow').html(`  <img src="{{asset('student_images/${response.image}')}}" alt="" width="100">
        <label for="exampleInputPassword1">Image</label>
    <input type="file" id="image" value="${response.image}" name="image1" class="form-control" id=""> 
   
    `)

    }
  })
}
</script>




<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('submit','#formdata2', function(e){
      e.preventDefault();
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  var formdata=new FormData($('#formdata2')[0]);
$.ajax({
  type:"POST",
  data:formdata,
  contentType: false,
  processData: false,
  url:"/student/updated",
  success:function(response){
    $('#edit').modal('hide')
     studentalldata();
     $('#name').val('')
     $('#roll').val('')
     $('#image').val('')
  }

})
    })
  })
</script>
@endsection
