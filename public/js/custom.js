
var filterarray = [];

$(function () {

    var acc = document.getElementsByClassName("des-accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = "100%";
        } 
      });
    }

    $("#upload_on_amazon").on("click", function () {
        var ids = [];
        $("input:checkbox[id=chkbx]:checked").each(function () {
            ids.push($(this).val());
        });
        if (ids.length === 0) {
          alert('Please select products to upload.');
        } else {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/product/upload',
            data: { 'ids': ids },
            beforeSend: function() {
              
                $('.loader').css("display", "block");
            },
            success: function(response)
            {
                //$('.loader').css("display", "none");
                window.location.href = '/walmartproductlist';
            }
          });
        }
    });

    $('#chkall').click(function() {
      var isChecked = $(this).prop("checked");
      $('#tblwalmart tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
    });

    $('#tblwalmart tr:has(td)').find('input[type="checkbox"]').click(function() {
      var isChecked = $(this).prop("checked");
      var isHeaderChecked = $("#chkall").prop("checked");
      if (isChecked == false && isHeaderChecked)
        $("#chkall").prop('checked', isChecked);
      else {
        $('#tblwalmart tr:has(td)').find('input[type="checkbox"]').each(function() {
          if ($(this).prop("checked") == false)
            isChecked = false;
        });
        $("#chkall").prop('checked', isChecked);
      }
    });

    $("#example2").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $("#tblwalmart").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "fixedHeader": [
      {
            "header": true,
            "headerOffset": 45,
      }],
      "scrollX": true,
      "scrollCollapse": true,
      "columnDefs": [
          { "width": 200, "targets": 11 }
      ],
    });
    $("#tblamazonpro").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "fixedHeader": [
      {
            "header": true,
            "headerOffset": 45,
      }],
      "scrollX": true,
      "scrollCollapse": true,
      "columnDefs": [
          { "width": 200, "targets": 1 }
      ],
    });
    $("#tblamazonstore").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "fixedHeader": [
      {
            "header": true,
            "headerOffset": 45,
      }],
      "scrollX": true,
      "scrollCollapse": true,
      "columnDefs": [
          { "width": 200, "targets": 2 }
      ],
    });
    $("#orderTable").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "scrollX": true,
      "scrollCollapse": true,
      "columnDefs": [
          { "width": 150, "targets": 0 },
          { "width": 130, "targets": 2 },
          { "width": 130, "targets": 3 }
      ],
    });
    setTimeout(function(){
      if ($('.alert').length > 0) {
        $('.alert').fadeOut("slow");
      }
    }, 10000);

    $(".add_filter").click(function(){
        var t = $(this).closest("div.card-body").find("select[name=filtercondition]").attr("data-title");
        var v = $(this).closest("div.card-body").find("input[name=filtervalue]").val();
        var f = $(this).closest("div.card-body").find("select[name=filtercondition]").val();

        if(v === ''){
          return false;
        } else {
          var rand = Math.random();
          var field = '<span class="btn_brand">'+t+' '+f+' '+v+'<a onclick="closespan(this,'+rand+');" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i></a></span>'
          $(this).closest('div.card-body').find("div.d-flex-inlinebtn").append(field);
          var elarray = [t,f,v,rand];
          filterarray.push( elarray );
        }
    });

    $(".applyfilter").click(function(){
      if(filterarray.length > 0){
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/amazonproduct/filter',
            dataType: "json",
            data: { 'filter': filterarray },
            beforeSend: function() {
                document.getElementById("mySidenav").style.width = "0";
                $('.loader').css("display", "block");
            },
            success: function(response)
            {
                console.log(response);
                var content = '';
                //content += '<tbody>'; -- **superfluous**
                for (var i = 0; i < response.length; i++) {
                     content += '<tr><td>'+ response[i].upc +'</td>';
                     content += '<td>'+ response[i].sku +'</td>';
                     content += '<td>'+ response[i].title +'</td>';
                     content += '<td>'+ response[i].brand +'</td>';
                     content += '<td>'+ response[i].color +'</td>';
                     content += '<td>'+ response[i].productType +'</td>';
                     content += '<td>'+ response[i].price +'</td>';
                     if (response[i].processingStatus == '_SUBMITTED_') {
                        var status = '<span class="badge bg-primary">SUBMITTED</span>';
                     } else if (response[i].processingStatus == '_CANCELED_') {
                        var status = '<span class="badge bg-danger">CANCELED</span>';
                     } else if (response[i].processingStatus == '_IN_PROGRESS_') {
                        var status = '<span class="badge bg-warning">IN PROGRESS</span>';
                     } else if (response[i].processingStatus == '_DONE_') {
                        var status = '<span class="badge bg-success">DONE</span>';
                     }
                     content += '<td>'+ status +'</td>';
                     content += '<td>'+ response[i].submissionId +'</td>';
                     content += '<td>'+ response[i].packageHeight +'</td>';
                     content += '<td>'+ response[i].packageLength +'</td>';
                     content += '<td>'+ response[i].packageWidth +'</td>';
                     content += '<td>'+ response[i].packageWeight +'</td>';
                     content += '<td>'+ response[i].size +'</td></tr>';
                }
                
                $('#tblamazonstore').DataTable().destroy();
                $('#tblamazonstore tbody').html(content);
                //$('#tblamazonstore').find('tbody').append(content);
                //$('#tblamazonstore').DataTable().draw();
                $("#tblamazonstore").DataTable({
                      "paging": true,
                      "lengthChange": true,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": true,
                      "fixedHeader": [
                      {
                            "header": true,
                            "headerOffset": 45,
                      }],
                      "scrollX": true,
                      "scrollCollapse": true,
                      "columnDefs": [
                          { "width": 200, "targets": 2 }
                      ],
                    }).draw();

                setTimeout(function(){
                    $('.loader').css("display", "none");
                }, 2000);
            },
            error: function (data) {
                alert("ERROR: ");
            }
        });
        console.log(filterarray);
      } else {
        return false;
      }
    });

    $(".walmartProductfilter").click(function(){
      if(filterarray.length > 0){
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/walmartproduct/filter',
            dataType: "json",
            data: { 'filter': filterarray },
            beforeSend: function() {
                document.getElementById("mySidenav").style.width = "0";
                $('.loader').css("display", "block");
            },
            success: function(response)
            {
                console.log(response);
                var content = '';
                //content += '<tbody>'; -- **superfluous**
                for (var i = 0; i < response.length; i++) {
                     content += '<tr><td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input custom-control-input-danger" name="chkbx[]" id="chkbx" value="'+response[i].id+'" style="z-index: 0;opacity: 1;" /></div></td>';
                     content += '<td><img src="'+window.location.origin+'/storage/walmartImg/'+response[i].images+'" alt="Image" width="100"></td>';
                     content += '<td>'+ response[i].price +'</td>';
                     content += '<td>'+ response[i].amazonPrice  +'</td>';
                     if (response[i].price > response[i].amazonPrice) {
                        var profitable = 'Walmart';
                     } else if (response[i].price <= response[i].amazonPrice) {
                        var profitable = 'Amazon';
                     } else {
                        var profitable = 'NA';
                     }
                     content += '<td>'+profitable+'</td>';
                     content += '<td>'+ response[i].referralFee +'</td>';
                     content += '<td>'+ response[i].closingFee +'</td>';
                     content += '<td>'+ response[i].perItemFee +'</td>';
                     content += '<td>'+ response[i].fbaFees +'</td>';
                     if (response[i].profit > 0) {
                        var profit = '<span class="badge bg-success">$'+response[i].profit+'</span>';
                     } else if (response[i].profit <= 0) {
                        var profit = '<span class="badge bg-danger">$'+response[i].profit+'</span>';
                     }
                     content += '<td>'+ profit +'</td>';
                     if (response[i].roi > 0) {
                        var roi = '<span class="badge bg-success">'+response[i].roi+'%</span>';
                     } else if (response[i].roi <= 0) {
                        var roi = '<span class="badge bg-danger">'+response[i].roi+'%</span>';
                     }
                     content += '<td>'+ roi +'</td>';
                     content += '<td>'+ response[i].name +'</td>';
                     content += '<td>'+ response[i].productid +'</td>';
                     content += '<td>'+ response[i].model +'</td>';
                     content += '<td>'+ response[i].brand +'</td>';
                     content += '<td>'+ response[i].productType +'</td>';
                     content += '<td>'+ response[i].upc +'</td>';
                     content += '<td>'+ response[i].delivery_days +'</td>';
                     content += '<td></td></tr>';
                }
                
                $('#tblwalmart').DataTable().destroy();
                $('#tblwalmart tbody').html(content);
                $("#tblwalmart").DataTable({
                      "paging": true,
                      "lengthChange": true,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": true,
                      "fixedHeader": [
                      {
                            "header": true,
                            "headerOffset": 45,
                      }],
                      "scrollX": true,
                      "scrollCollapse": true,
                      "columnDefs": [
                          { "width": 200, "targets": 11 }
                      ]
                }).draw();

                setTimeout(function(){
                    $('.loader').css("display", "none");
                }, 2000);
            },
            error: function (data) {
                alert("ERROR: ");
            }
        });
      } else {
        return false;
      }
    });

});

function closespan(ele,rand) {
  for (var i = 0; i < filterarray.length; i++) {
    for ( k=0; k<filterarray[i].length; k++){
      if (filterarray[i][k] === rand){
          var index = i;
          break;
      } 
    }
  }
  filterarray.splice(index, 1);
  $(ele).closest("span.btn_brand").remove();
}

function openNav() {
  document.getElementById("mySidenav").style.width = "450px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}


/* progressbar */

document.onreadystatechange = function(e)
{
  if(document.readyState=="interactive")
  {
    var all = document.getElementsByTagName("div");
    for (var i=0, max=all.length; i < max; i++) 
    {
      set_ele(all[i]);
    }
  }
}

function check_element(ele)
{
    var all = document.getElementsByTagName("div");
    var totalele=all.length;
    var per_inc=100/all.length;
    if($(ele).on())
    {
        var prog_width=per_inc+Number(document.getElementById("progress_width").value);
        document.getElementById("progress_width").value=prog_width;
        $("#bar1").animate({width:prog_width+"%"},10,function(){
          if(document.getElementById("bar1").style.width=="100%")
          {
            $(".progresstop").fadeOut("slow");
          }     
        });
    }

    else  
    {
        set_ele(ele);
    }
}

function set_ele(set_element)
{
    check_element(set_element);
}



