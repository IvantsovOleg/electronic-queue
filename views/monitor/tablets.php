<?php
use yii\widgets\Pjax;
?>

    <div class="parent">
        <div class="block" id="monitorTables">
            <h3 class="room text-center">
			<?php
				if (isset($data) && isset($data['ROOM']))
					echo $data['ROOM'];
			?>
       	    </h3>

            <h4 class="roomnote text-center">
			<?php
				if (isset($data) && isset($data['NOTE']))
					echo $data['NOTE'];
			?>
       	    </h4>

            <h1 class="code text-center">
			<?php
				if (isset($data) && isset($data['CODE']))
					echo $data['CODE']
			?>
			</h1>
            <div class="blur-fon"></div>
        </div>
    </div>


<script type="text/javascript">

$(document).ready(function () {
    var refresh = function() {
       $.ajax({
         url: "index.php?r=monitor/monitortablets",
         dataType: 'json',
         error: function () {
            console.log('error')
         },
         success: function (response) {
			
         	var code;
			var room;
			var roomnote;
         		if (response.data != null) {
				
					if (response.data.CODE && response.data.CODE != 'undefined') {
						code = response.data.CODE;
					} else {
						code = '  -  ';
					}
					
					if (response.data.ROOM && response.data.ROOM != 'undefined') {
						room = response.data.ROOM;
						$('h3.room').text(room);
					}

					if (response.data.NOTE && response.data.NOTE != 'undefined') {
						roomnote = response.data.NOTE;
						$('h4.roomnote').text(roomnote);
						$('h4.roomnote').css({'color': 'red'});
						//$('h4.roomnote').css({'margin-bottom':'80pt'});
					}
				} else {
					code = '  -  ';
				}
				
				if (code == '  -  ') 
				{
					$('h1.code').text('ожидайте вызова');
					$('h1.code').css({'color': 'red', 'font-size':'120pt'});
				}
				else
				{
					$('h1.code').text(code);
					$('h1.code').css({'color': 'black','font-size':'280pt'});
				}


            }
        });
    };


setInterval(function(){
    refresh() // this will run after every 5 seconds
}, 5000);

});

	

</script>