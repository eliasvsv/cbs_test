<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/all.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <title>CBS Messenger by Elias Espino</title>
</head>

<body>
<div class="container">
<div class="row">
    <div class="col-6">
    <table id="lastMessages" class="table">

</table>
    </div>
    <div class="col-6">
    <form>
        <div class="form-row">
          <div class="form-group">
            <label for="phoneNumber">Number</label>
            <input type="text" class="form-control" id="phoneNumber" placeholder="+12135555555">
          </div>
          <div class="form-group">
            <label for="phoneNumber">Message</label>
            <textarea class="form-control" placeholder="Message" id="message"></textarea>
          </div>
        </div>
        <div class="form">
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="button">Send</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="jquery/jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".btn").on("click", function() {
        $.post("/send", {
          number: $("#phoneNumber").val(),
          text: $("#message").val()
        }, function(data) {
          document.location.reload();
          alert("Message Sent");
        });
      });
      $('#lastMessages').DataTable( {
    ajax: '/getlastest',
    columns: [
        { data: 'id' },
        { data: 'date' },
        { data: 'to' },
        { data: 'message' },
        { data: 'statusCode' }
    ]
    
} );
    });
  </script>
</body>

</html>