<!DOCTYPE html>
<html>
   <head>
      <title>PHP Error: <?php echo $errstr; ?></title>
      <link href='http://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
      <style type="text/css">
         body {
            width:960px;
            margin:0 auto;
         }
         body, p, h1, h2, h3, h4, h5, h6 {
            font-family:"Source Code Pro", sans-serif;
         }
         h2, p, pre {
            display:none;
         }
         pre {
            padding-top:0px;
            margin-top:-50px;
         }
         pre ol li {
            min-height:40px;
            line-height:40px;
            padding-left:15px;
         }
         pre ol li:nth-child(even) {
            background:#efefef;
         }
         pre ol li:nth-child(odd) {
            background:#EB7260;
         }
      </style>
   </head>
   <body>
      <header>
         <h1>PHP Error</h1>
      </header>
      <div id="content">
         <h2>Debug Backtrace</h2>
         <p>
            <strong>Error Number: </strong> <code><?php echo $errno; ?></code><br>
            <strong>File: </strong> <code><?php echo $errfile; ?></code><br>
            <strong>Line Number: </strong> <code><?php echo $errline; ?></code><br>
            <strong>Error String: </strong> <code><?php echo $errstr; ?></code><br>
         </p>
         <pre>
            <ol>
         <?php
         foreach($trace as $item)
             echo '<li>'.(isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()' . "</li>";
         ?>
            </ol>
         </pre>
      </div>
      <script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'></script>
      <script type="text/javascript">
         $(function() {
            $('h2').delay(300).fadeIn();
            $('p').delay(600).fadeIn();
            $('pre').delay(900).fadeIn();
         });
      </script>
   </body>
</html>