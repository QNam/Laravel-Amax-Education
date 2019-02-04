@if (Session::has('success'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('success') }}",
					            addclass: 'bg-success',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('warning'))
					<script>
						$( window ).load(function() {

						  new PNotify({
							    title: '',
					            text: "{{Session::get('warning') }}",
					            addclass: 'bg-warning',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('error'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('error') }}",
					            addclass: 'bg-danger',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif

					@if (Session::has('info'))
					<script>
						$( window ).load(function() {
						  new PNotify({
							    title: '',
					            text: "{{Session::get('info') }}",
					            addclass: 'bg-info',
					            delay: 1000,
					            icon:''
							})
						});
						
						
					</script>
					@endif