<form method="post" id="form">
	Ссылка <input type="text" size="80" id="longLink" name="longLink"><br>
	<input id="submit" type="button" name="submitLink" value="Сократить">
</form>
<div id="resultOfSubmitLink"></div>

<script type="text/javascript">
	$(function() {
		$("#submit").click(function() {
			var formData = $("#form").serialize(); 
			$.ajax({
				url: 'http://shortener.local/index.php/Index/index', 
				type: "post",
			  	data: formData,
				success: function(data) {
					var result = JSON.parse(data);
					$('#resultOfSubmitLink').text();
					$('#resultOfSubmitLink').text(result.message);
					$('#resultOfSubmitLink').removeClass();
					if (result.status == true) {
						//$("#longLink").val('');
						$('#resultOfSubmitLink').addClass('text-info');
					} else {
						$('#resultOfSubmitLink').addClass('text-danger');
					}
				}
			});
		});
	});
</script>