@extends('admin.admin_master')



@section('Admindata')

<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class=" card-header" data-card-widget="collapse">
        <h3 class="card-title">Add Campus<Section></Section>
          <Section></Section>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>



      <div class="card-body">
        <div class="container-fluid">
          <form id="AddConfigForm" onsubmit="return false" method="POST">
            <div class="row align-items-center ">
              <div class="col-md-4" style="display: none">
                <label for="campusid" class="form-label"><b>Campus Id</b></label>
                <input type="text" class="form-control form-control-sm" id="campusid" value="0" name="campusid"
                  placeholder="">
              </div>
              <div class="col-md-5">
                <label for="CampusName" class="form-label"><b>Campus Name</b></label>
                <input type="text" class="form-control form-control-sm" id="CampusName" required name="CampusName"
                  placeholder="">
              </div>
              <div class="col-md-4">
                <label for="CampusPrefix" class="form-label"><b>Campus Prefix (<span class="text-danger">Prefix can't be
                      updated later</span>)</b></label>
                <input type="text" class="form-control form-control-sm" id="CampusPrefix" required name="CampusPrefix"
                  placeholder="">
              </div>
              <div class="col-md-3">
                <label for="CampusEmail" class="form-label"><b>Campus Email</b></label>
                <input type="email" class="form-control form-control-sm" id="CampusEmail" required name="CampusEmail"
                  placeholder="">
              </div>
            </div>


            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="DefaultBoard" class="form-label"><b>Board Name</b></label>
                  <input type="text" class="form-control form-control-sm" id="DefaultBoard" required name="DefaultBoard"
                    placeholder="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="DefaultReligion" class="form-label"><b>Religion Name</b></label>
                  <select class="form-control form-control-sm" id="DefaultReligion" required name="DefaultReligion"
                    placeholder="">
                    <option value="">Select Religion</option>
                    <option value="Islam">Islam</option>
                    <option value="Christianity">Christianity</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Judaism">Judaism</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="Phone" class="form-label"><b>Phone</b></label>
                  <input type="tel" maxlength="11" class="form-control form-control-sm" id="Phone" required name="Phone"
                    placeholder="">
                </div>
              </div>
            </div>


            <div class="row align-items-center  ">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="Phone1"><b>Phone 1</b></label>
                  <input type="tel" maxlength="11" class="form-control form-control-sm" id="Phone1" required
                    name="Phone1" placeholder="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="BankName" class="form-label"><b>Bank Name</b></label>
                  <input type="text" class="form-control form-control-sm" id="BankName" name="BankName" placeholder="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label" for="AccountNumber"><b>Account Number</b></label>
                  <input type="text" name="AccountNumber" class="form-control form-control-sm" id="AccountNumber">
                </div>
              </div>
            </div>


            <div class="row align-items-center   ">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="RegistrationDate"><b>Registration Date</b></label>
                  <input type="date" name="RegistrationDate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm" id="RegistrationDate">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="LogoPath"><b>Logo Path</b></label>
                  <input type="file" accept="image/*" onchange="loadImage(event)" name="image"
                    class="form-control-sm form-control-file" id="image">
                </div>
              </div>
              <div class="col-md-2">
                <div height="100px" width="100px">
                  <img id="logo" src="#" alt="Logo Path" height="100px" width="100px" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="banklogo"><b>Bank Logo</b></label>
                  <input type="file" accept="image/*" onchange="loadBankLogo(event)" name="banklogo"
                    class="form-control-sm form-control-file" id="banklogo">
                </div>
              </div>
              <div class="col-md-2">
                <div height="100px" width="100px">
                  <img id="blogo" src="#" alt="Logo Path" height="100px" width="100px" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label" for="SchoolStatus"><b>School Status</b></label>
                  <select name="SchoolStatus" required class="form-control form-control-sm" id="SchoolStatus">
                    <option value="Active">Active</option>
                    <option value="InActive">InActive</option>
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="DefaultAddress"><b>Campus Address</b></label>
                  <textarea class="form-control form-control-sm" id="DefaultAddress" rows=""
                    name="DefaultAddress"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="DefaultAddress1"><b>Campus Address 1</b></label>
                  <textarea class="form-control form-control-sm" id="DefaultAddress1" rows=""
                    name="DefaultAddress1"></textarea>
                </div>
              </div>
            </div>

            <div class="row align-items-center   ">
              <div class="col-md-12">
                <input name="submit" id="insert" class="btn btn-sm btn-primary btn-block" type="submit" value="Save">
              </div>
              <div class="col-md-12">
                <input type="submit" name="submit" id="update" class="btn btn-sm btn-success btn-block"
                  style="display: none;" value="Update">
                <input type="submit" onclick="ResetFormByCancelKey()" id="cancelbtn" class="btn btn-sm btn-danger btn-block"
                  style="display: none;" value="Cancel">
              </div>
            </div>


          </form>
          <hr>
          <div class="row" style="overflow-x:auto;overflow-y:auto;">
            <table id="example1" class="table table-striped" style="margin:20px">
              <thead>
                <tr>
                  <th>S.No </th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Prefix</th>
                  <th>Phone</th>
                  <th>Phone1</th>
                  <th>Campus Address </th>
                  <th>Campus Address 1</th>
                  <th>Board Name</th>
                  <th>ReligionName</th>
                  <th>BankName</th>
                  <th>AccountNumber</th>
                  <th>RegistraionDate</th>
                  <th>SchoolStatus</th>
                  <th></th>

                  <!-- <th>SubCat_name</th> -->
                </tr>
              </thead>
              <tbody id="CampusData">
              </tbody>
            </table>
          </div>
        </div>

      </div>





      <!-- /.card-body -->

    </div>

    <!-- /.card -->

  </div>



</div>

<script>
  function ResetFormByCancelKey(){
    $("#AddConfigForm").trigger("reset");
    $('#update').hide();
    $('#cancelbtn').hide();
    $('#insert').show();
    $('#insert').prop('type', 'submit');
    $('#logo').attr('src', "#");
    $('#blogo').attr('src', "#");
  }
  $(document).ready(function(){

  $('#CampusPrefix').keyup(function(){
    let vall = $('#CampusPrefix').val();
    let res = vall.replace(/-/g, '');
    $('#CampusPrefix').val(res.toUpperCase() + '-');
  });

  $('#insert').show();
  LoadCompany();
  var dataa='';

  $("#update").click(function(){
    var formData = new FormData(document.getElementById("AddConfigForm"));
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
          url: "{{ route('admin.UpdateCampusConfigration') }}",
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(result){
            if(result == 'exists'){
              swal("Error!", "Campus have data, you can not change the prefix. Other data have succssfully updated.", "warning");
            }else{
              swal("Good job!", "Campus is successfully updated!", "success");
            }
            LoadCompany();
            $("#AddConfigForm").trigger("reset");
            $('#update').hide();
            $('#cancelbtn').hide();
            $('#update').hide();
            $('#insert').show();
            $('#insert').prop('type', 'submit');
            $('#CampusPrefix').prop('required','required');
          },error: function(error) {
            $.each(error.responseJSON.errors, function(field_name,error){
              swal('Warning', error[0], 'warning');
                // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            });
          }
          });
  });

  $('#insert').click(function(){
      //  e.preventDefault();
      var formData = new FormData(document.getElementById("AddConfigForm"));
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
        $.ajax({
          url: "{{ route('admin.AddCampusConfigration') }}",
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(result){
            $("#AddConfigForm").trigger('reset');
            LoadCompany();
            swal("Good job!", "Campus is successfully added!", "success");
            $("#AddConfigForm").trigger("reset");
            $('#logo').attr('src', "#");
            $('#blogo').attr('src', "#");
          },
          error: function(error) {
            $.each(error.responseJSON.errors, function(field_name,error){
              swal('Warning', error[0], 'warning');
                // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            });
          }
        });
      });

  });

  function LoadCompany() {
    // alert();
      $.ajax({
      dataType: "json",
      url: "{{ route('admin.ViewCampusConfigration') }}",
      success: function(CampusData)
      {
      dataa=JSON.parse(CampusData);
      var j=1;
      var html='';
      for (i=0; i < dataa.length; ++i) {
          html=html+'<tr  ondblclick="EditCampus('+dataa[i].campusid+','+ i +')">'+
          '<td>'+ j +'</td>'+
          '<td>'+dataa[i].CampusName +'</td>'+
          '<td>'+dataa[i].CampusEmail +'</td>'+
          '<td>'+dataa[i].CampusPrefix +'</td>'+
          '<td>'+dataa[i].Phone +'</td>'+
          '<td>'+dataa[i].Phone1 +'</td>'+
          '<td>'+dataa[i].DefaultAddress +'</td>'+
          '<td>'+dataa[i].DefaultAddress1 +'</td>'+
          '<td>'+dataa[i].DefaultBoard +'</td>'+
          '<td>'+dataa[i].DefaultReligion +'</td>'+
          '<td>'+dataa[i].BankName +'</td>'+
          '<td>'+dataa[i].AccountNumber +'</td>'+
          '<td>'+dataa[i].RegistraionDate +'</td>'+
          '<td>'+dataa[i].SchoolStatus +'</td>'+
          '<td> <a style="color: #FFC107;" ><i class="fas fa-edit"  title="Edit"></i></a></td>'
          +'</tr>';
            j++;
      }

            $('#CampusData').html(html);
            var table =$('#example1').DataTable();

      },
      error: function(error) {
          $.each(error.responseJSON.errors, function(field_name,errorr){
            swal('Warning', errorr[0], 'warning');
              // $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
          });
        }

    });
  }

// logo image upload display
var loadImage = function(event) {
  var image = document.getElementById("logo");
  image.src = URL.createObjectURL(event.target.files[0]);
};
var loadBankLogo = function(event) {
  var image = document.getElementById("blogo");
  image.src = URL.createObjectURL(event.target.files[0]);
};

function EditCampus(campusid,i) {
  $('#insert').hide();
  $('#insert').prop('type', '');
  $('#update').show();
  $('#cancelbtn').show();
  $('#CampusName').val(dataa[i].CampusName);
  $('#campusid').val(dataa[i].campusid);
  $('#CampusEmail').val(dataa[i].CampusEmail);
  // $('#CampusPrefix').val(dataa[i].CampusPrefix);
  $('#CampusPrefix').prop('required','');
  $('#DefaultBoard').val(dataa[i].DefaultBoard);
  $('#DefaultReligion').val(dataa[i].DefaultReligion);
  $('#Phone').val(dataa[i].Phone);
  $('#Phone1').val(dataa[i].Phone1);
  $('#BankName').val(dataa[i].BankName);
  $('#AccountNumber').val(dataa[i].AccountNumber);
  $('#RegistrationDate').val(dataa[i].RegistraionDate);
  $('#LogoPath').val(dataa[i].LogoPath);
  $('#SchoolStatus').val(dataa[i].SchoolStatus);
  $('#DefaultAddress').val(dataa[i].DefaultAddress);
  $('#DefaultAddress1').val(dataa[i].DefaultAddress1);
}




</script>



@endsection
