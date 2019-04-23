<?php
include('db_connect.php');

$ic = "000000-00-0000";
$sql_data = "SELECT *
             FROM booking
             WHERE ic = '$ic'";
$result_data = $conn->query($sql_data);
$numRows = $result_data->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
  <body>
    <div class="container">
      <div class="row" style="margin-top: 1%;">
        <div class="col-sm"></div>
        
        <div class="col-sm">
          <form>
            <div class="form-group">
              <label for="exampleInputEmail1">IC</label>
              <input readonly="" type="text" class="form-control form-control-sm" id="ic" value="<?=$ic;?>">
            </div>
            <div class="form-group">
              <label for="adult">Adult</label>
              <select class="form-control form-control-sm" id="adult">
                <option value="0">-- Please Select --</option>
                <?php
                for($i=1; $i<=5; $i++){
                ?>
                <option value="<?=$i;?>"><?=$i;?></option>
                <?php
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="adult">Children</label>
              <select class="form-control form-control-sm" id="children">
                <option value="0">-- Please Select --</option>
                <?php
                for($i=1; $i<=5; $i++){
                ?>
                <option value="<?=$i;?>"><?=$i;?></option>
                <?php
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="adult">Infants</label>
              <select class="form-control form-control-sm" id="infans">
                <option value="0">-- Please Select --</option>
                <?php
                for($i=1; $i<=5; $i++){
                ?>
                <option value="<?=$i;?>"><?=$i;?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </form>
          <button onclick="submit()" class="btn btn-primary btn-sm">Submit</button>
        </div>
        
        <div class="col-sm"></div>
      </div>

      <div class="row" style="margin-top: 1%;">
        <input type="hidden" id="ttlRcd" class="form-control form-control-sm" value="<?=$numRows;?>">
        <form>
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">IC</th>
                <th scope="col">Adult No</th>
                <th scope="col">Children No</th>
                <th scope="col">Infants No</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $num = 1;
              while($row_data = $result_data->fetch_array()){
                $id_book = $row_data['id_book'];
                $ic = $row_data['ic'];
                $adult = $row_data['adult'];
                $children = $row_data['children'];
                $infants = $row_data['infants'];
                $status = $row_data['status'];
              ?>
              <tr>
                <td><?=$num;?></td>
                <td>
                  <?=$ic;?>
                  <input type="hidden" id="icNo" value="<?=$ic;?>">
                </td>
                <td><?=$adult;?></td>
                <td><?=$children;?></td>
                <td><?=$infants;?></td>
                <td><?=$status;?></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="del(<?=$id_book;?>)">Remove</button></td>
              </tr>
              <?php
              $num++;
              }
              ?>
            </tbody>
          </table>
        </form>
      </div>
      <div id="div_butang" class="row">
        <button onclick="confirm()" class="btn btn-primary btn-sm">Confirm</button>
      </div>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var ttlRcd = $('#ttlRcd').val();

      if(ttlRcd == '0'){
        $('#div_butang').attr("style", "visibility:hidden");
      };
    });

    function submit(){
      var ic = $('#ic').val();
      var adult = parseInt($('#adult').val());
      var children = parseInt($('#children').val());
      var infans = parseInt($('#infans').val());
      var guests = adult + children;
      // alert(guests);
      // alert(adult);
      // alert(children);
      // alert(infans);
      if(ic == ''){
        alert('Please fill in the data');
        return false;
      }
      if(ic == '' && adult == 0 && children == 0 && infans == 0){
        alert('Please fill in the data');
        return false;
      }
      if(guests > 7){
        alert('In one booking, maximum guests can be 7 (excluding infants)');
        return false;
      }
      if(adult == 0){
        alert('At least 1 adult should be in one room');
        return false; 
      }
      if(adult < infans){
        alert('No room can have more infants than adults. (i.e. adults >= infants per room)');
        return false; 
      }

      $.ajax({
        url: 'booking.php?action=insert',
        method: 'POST',
        data: {
          ic: ic,
          adult: adult,
          children: children,
          infans: infans
        },
        success: function(data){
          alert(data);
          console.log(data);
          location.reload();
        }
      });
    }

    function confirm(){
      var icNo = $('#icNo').val();

      $.ajax({
        url: 'booking.php?action=update',
        method: 'POST',
        data: {
          icNo: icNo
        },
        success: function(data){
          // alert(data);
          location.reload();
        }
      });
    }

    function del(idbook){
      var idbook = idbook;

      $.ajax({
        url: 'booking.php?action=del',
        method: 'POST',
        data: {
          idbook: idbook
        },
        success: function(data){
          location.reload();
        }
      });

      // var x = confirm('Sure to remove?');

      // if(x){
      //   $.ajax({
      //     url: 'booking.php?action=del',
      //     method: 'POST',
      //     data: {
      //       idbook: idbook
      //     },
      //     success: function(data){
      //       location.reload();
      //     }
      //   });
      // }else{
      //   return false;
      // }
    }
  </script>

</html>