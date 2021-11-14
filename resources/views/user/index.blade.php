@extends('layouts.master')
@section('master_content')
<button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-success">add new user</button>
<div class="card  mb-3">
  <div class="card-header text-white bg-info">Header</div>
  <div class="card-body">
   <table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">name</th>
      <th scope="col">phone</th>
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
        <form id="formdata" method="post" action="" enctype="multipart/form-data">
 @csrf
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="name" placeholder="Password">
    </div>
  </div>
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Phone</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="phone" id="phone" placeholder="Password">
    </div>
  </div>
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">image</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="image" name="image" placeholder="Password">
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
</div>



<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formdata2" method="post" action="" enctype="multipart/form-data">
 @csrf
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="name1" placeholder="Password">
    </div>
  </div>
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Phone</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="phone" id="phone1" placeholder="Password">
      <input type="hidden" id="data_id" name="id">
    </div>
  </div>
    <div class="form-group row" id="imageshow">
    <label for="inputPassword" class="col-sm-2 col-form-label">image</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="image1" name="image" placeholder="Password">
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
</div>


<script type="text/javascript">
	function useralldata(){
		$.ajax({
			type:"GET",
			url:"/user/create",
			datatype:'json',
			success:function(response){
				rows="";
				$.each(response, function(key,value){
					rows+=` 
						<tr>
					      <th scope="row">${value.id}</th>
					      <td>${value.name}</td>
					      <td>${value.phone}</td>
					      <td><img src="{{asset('user_images/${value.image}')}}" width="100" alt=""></td>
					      <td> <button class="btn btn-primary btn-sm" type="button" onclick="editdata(${value.id})">edit/view</button>
					      <button class="btn btn-danger btn-sm" onclick="deletedata(${value.id})" type="button">delete</button>
					      </td>
					    </tr>
					 `
				})
				$('tbody').html(rows)	

				

			}

		})
	}
	useralldata();
</script>





<!-- script for store data -->
<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('submit','#formdata',function(e){
			e.preventDefault();
			var formdata= new FormData($('#formdata')[0]);
			$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
			$.ajax({
				type:"POST",
				url:"/user",
				data:formdata,
				contentType: false,
				processData: false,
				success:function(response){
					$('#exampleModalLong').modal('hide')
					useralldata();
					$('#name').val('')
					$('#phone').val('')
					$('#image').val('')


				}
			})
		})
	})
</script>






<!-- script for delete recourd -->
<script type="text/javascript">
	function deletedata(id){
		$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
		$.ajax({
			type:"DELETE",
			url:"/user/"+id,
			datatype:"json",
			success:function(response){
				useralldata();

			}
		})
	}
</script>

<!-- edit -->

<script type="text/javascript">
	function editdata(id){
		$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
		$.ajax({
			type:"GET",
			url:"/user/"+id+"/edit",
			datatype:"json",
			success:function(response){
				$('#editmodal').modal('show')
				$('#name1').val(response.name)
				$('#phone1').val(response.phone)
				$('#data_id').val(response.id)

				
				$('#imageshow').html(`  <label for="inputPassword" class="col-sm-2 col-form-label">image</label>
    <div class="col-sm-10">
     <img src="{{asset('user_images/${response.image}')}}" alt="" width="100">
      <input type="file" class="form-control" id="image1" name="image" placeholder="Password">

    </div>
					`)



			}
		})
	}
</script>






<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('click')
	})
</script>




<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('submit','#formdata2',function(e){
			e.preventDefault();
			var formdata= new FormData($('#formdata2')[0]);
			$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
			$.ajax({
				type:"POST",
				url:"/user/updated",
				data:formdata,
				contentType: false,
				processData: false,
				success:function(response){
					$('#editmodal').modal('hide')
					useralldata();
					$('#name1').val('')
					$('#phone1').val('')
					$('#image1').val('')


				}
			})
		})
	})
</script>





@endsection