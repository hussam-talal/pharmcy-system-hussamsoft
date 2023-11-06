  <br>
  <p style="color:brown"> 
    @if($the_final_Balance >0)
              مدين ب ({{ $the_final_Balance*1 }}) ريال  
              @elseif ($the_final_Balance <0)
              دائن ب ({{ $the_final_Balance*1*(-1) }})   ريال
  
            @else
        متزن
            @endif


  </p>
          