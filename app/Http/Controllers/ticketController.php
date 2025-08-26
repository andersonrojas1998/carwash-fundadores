<?php
namespace App\Http\Controllers;
use App\Model\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function ticketPrint($id)
    {    
      $venta = Venta::find($id);
      $productos = DB::SELECT("CALL sp_groupSalesProduct('$venta->id')");
      return view('ticket.pdf_ticket', compact('venta', 'productos'));
     
    }
    public function sendMessageWpp(){

  
  $url='https://graph.facebook.com/v17.0/107778335707191/messages';
  $token='EAAzWkO2BxG8BAJdZAqJV9dNzXoBAoUQeIEaIYvqQhcdq4LXImxZAZCmjBzI8w66ro5Ti7RPvwagjNhpdf4F7LtVNixZCQZCZAqUPUXpGKaD4pZCMrVvMPQGTBj2rQCLqoZCj6eOYSynC55f1ciVktNF4MmDNhf8fzgNGIqQY9HZAs7QjAVlSdTtfuiHcvHwB6h3Ru9pNaR7ZBOGsrZBMHEgCSEK';
  $telefono='573102086587';
    $message=''
    .'{'
    . '"messaging_product": "whatsapp",'
    .'"recipient_type": "individual",'

    .'"to": "'.$telefono.'", '
      .'"type": "text", '
      .'"text": '
        .'{ '
          .'"preview_url": false, '
          .'"body": "Hola , como estas  " '
        .'}' 
      .'}';



   // dd(json_encode($message));

    $curl=curl_init();

    $header=array("Authorization: Bearer ".$token,"Content-Type: application/json ");

    curl_setopt($curl,CURLOPT_URL,$url);
    //curl_setopt($curl,CURLOPT_POST, 1); // Specify the request method as POST
    curl_setopt($curl,CURLOPT_POSTFIELDS,$message);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects

        

    $response=json_decode(curl_exec($curl),true);

    //dd(curl_getinfo($curl));
   
  
    curl_close($curl);
    
    dd($response);



/*
header('Content-Type: application/json'); // Specify the type of data
$ch = curl_init($url); // Initialise cURL
$post = json_encode($message); // Encode the data array into a JSON string
$authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
$result = curl_exec($ch); // Execute the cURL statement
curl_close($ch); // Close the cURL connection
dd($result);
return json_decode($result); // Return the received data
*/
    


    }

}
