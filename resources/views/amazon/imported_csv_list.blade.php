<!-- Extends template page-->
@extends('app')

@section('title', 'Amazon Product List')

<!-- Specify content -->
@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class') }}">
               {{ Session::get('message') }}
            </div>
          @endif
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" style="cursor:pointer" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Imported File</th>
                <th>Date</th>
                <th>Number of product</th>
              </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($imported_csv as $list)
                    <tr class="pointer" data-href="amazonExportedList?fileID={{ $list->id }}">
                        <td>{{ $i }}</td>
                        <td>{{ $list->csvName }}</td>
                        <td>{{ $list->created_at }}</td>
                        <td>--</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="detail">
            
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">

  $(".pointer").click(function() {
      window.location = $(this).data("href");
  });

  function fetchData(transId='',o_id='',bbpsid='',number='',amount='',image='',status='',comment=''){
        
      $("#myModal").modal('show');
  
      $("#o_id").val(o_id);
      $("#bbpsid").val(bbpsid);
      $("#mobile_number").val(number);
      $("#amount").val(amount);
      if(status == 'Failure'){

          $("#status").val(status);
          $(".comment_section").show();
          $("#comment").prop('disabled', false);
          $("#comment").val(comment);
      } else {
          $("#comment").prop('disabled', true);
      }
      $("#edit_id").val(transId);
      if(image){
          var extension = image.substr( (image.lastIndexOf('.') +1) );

          if(extension == 'pdf'){
              $("#pdf_img").html('<iframe src="uploads/'+image+'" width="800px" height="800px"></iframe>');
          } else {
              $('#transImg').attr('src', 'uploads/'+image);
          }
      }
  }

  function viewdetail(data){
    //console.log(data.productid);
    //$('#detail').html(data);
    $( "#detail" ).append( data );
    $('#productModal').modal('toggle');
  }
</script>
@stop