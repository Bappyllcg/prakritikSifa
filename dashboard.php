<?php 
  session_start();
  if(!isset($_SESSION['login'])){
    header("location:./login.html");
  }
?>

<!doctype html>
<html lang="en-US">

<head>
  <meta charset="utf-8">
  <title>গ্যাস ক্লিয়ার পাউডার</title>
  <meta name="description" content="গ্যাস্ট্রিকের প্রাকৃতিক উপায়ে চিরস্থায়ী সমাধান">
  <meta name="title" content="গ্যাস ক্লিয়ার পাউডার">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180" href="./images/ico/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/ico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/ico/favicon-16x16.png">
  <link rel="manifest" href="./site.webmanifest">
  <!-- Place favicon.ico in the root directory -->

  <!-- data table css  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.0/bootstrap-table.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">


  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="css/sweetalert.css">
  <!-- Main CSS -->
  <link rel="stylesheet" href="style.css" type="text/css" media="all">
  <!-- Responsive Css  -->
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <header class="main-header">
    <div class="container">
      <div class="header-wrp">
        <!-- left  -->
        <div class="header-left">
          <a href="index.html"><img src="images/logo.png" alt="abc" width="auto" height="auto"></a>
        </div>
        <!-- right  -->
        <div class="header-right">
          <ul>
            <li><a href="tel:0170000000"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
              <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            </svg></a></li>
            <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
            </svg></a></li>
            <li><a class="logout-btn" href="./logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>


  <section class="dash-board-sec">
    <div class="container">
      <div class="dash-wrap">
        <!-- table  -->
        <div class="dash-table">
          <table id="example" class="table display" cellspacing="0">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Address</th>
          <th>Mobile No</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
    
      <tbody>
        <?php 
                require_once('./inc/db.php');
                $order = "SELECT * FROM orders ORDER BY id DESC";
                $order_query = $conn->query($order);
                $i = 0;
                while($order = $order_query->fetch_object()) : 
                $i++;
              ?>
        <tr class="<?php echo $order->status; ?>">
          <td><?php echo $i; ?></td>
          <td><?php echo $order->name; ?></td>
          <td><?php echo $order->address; ?></td>
          <td><a href="tel:<?php echo $order->mobile; ?>"><?php echo $order->mobile; ?></a></td>
          <td><?php echo $order->status; ?></td>
          <td><?php echo $order->date; ?></td>
          <td class="ac-btn">
            <?php if($order->status != 'Cancel') : ?>
            <form action="./inc/change-status.php" method="POST">
              <input type="hidden" name="ststus" value="Cancel">
              <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
              <button class="cencal">Cancel</button>
            </form>
            <?php endif; ?>
            <?php if($order->status != 'Approve') : ?>
            <form action="./inc/change-status.php" method="POST">
              <input type="hidden" name="ststus" value="Approve">
              <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
              <button>Approve</button>
            </form>
            <?php endif; ?>
          </td>

        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
        </div>
      </div>
    </div>
  </section>

 





    <!-- Footer Section  -->
  <footer>
    <div class="container">
      <div class="footer-wrap">
        <a href="#">গোপনীয়তা নীতি</a>
        <a href="#">শর্তাবলী </a>
      </div>
    </div>
  </footer>
  <!-- Footer Section  -->

 


<script src="js/vendor/jquery-3.6.1.min.js"></script>
<script src="js/vendor/modernizr-3.7.1.min.js"></script>
<!-- sweetalert js  -->
<script src="js/sweetalert.js"></script>
<!-- LLCG Slider  -->
<script src="js/LLCGslider.js"></script>

<!-- data table js  -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>


<!-- Main Js -->
<script type="text/javascript" src="js/script.js"></script>
</body>

</html>
