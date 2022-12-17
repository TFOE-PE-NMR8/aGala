<div class="modal fade " id="viewRegistrantAndGuest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <h4>Registrant Name: {{ $getRegistrant->first_name }} {{ $getRegistrant->last_name }}</h4>
        <h4>Total Amount: ₱   {{ $getRegistrant->total_amount }}</h4>
        <h4>
          Paid Amount:
            @if ($getRegistrant->paid_amount != null)
              ₱ {{ $getRegistrant->paid_amount }}
            @else
              ₱ 0
            @endif
        </h4>
        <h4>Balance Amount: ₱ {{$balance}}</h4>
      </div>


      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Relation</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <th scope="row">1</th>
                    <td>{{ $getRegistrant->first_name }} {{ $getRegistrant->last_name }} {{ $getRegistrant->id }}</td>
                    <td>Registrant</td>
                    <td>N/A</td>
                    <td>
                        <button type="button" class="btn btn-primary">Attend</button>
                    </td>
                </tr> -->
                @foreach($arrayRegistrantAndGuest as $data)

                <tr>
                    <th scope="row">{{ $loop->index+1}}</th>
                    <td>
                      @if ($data->name)
                        {{ $data->name }}
                      @else
                        {{ $data->first_name }} {{ $data->last_name }}
                      @endif
                    </td>
                    <td>
                      @if ($data->name)
                        Guest
                      @else
                        Registrant
                      @endif
                    </td>
                    <td>
                      @if ($data->relation)
                        {{ $data->relation }}
                      @else
                        N/A
                      @endif
                    </td>
                    <td>
                      @if ( $loop->index+1 <= $countNotYetPaid)
                        @if ($data->is_attend != "Attend")
                          @php
                            $status = "";
                            if ($data->name) {
                              $status = "Guest";
                            } else {
                              $status = "Registrant";
                            }
                          @endphp
                          <!-- <button type="button" class="btn btn-primary btn-attend" data-url="{{ URL::to('/attend/'.$status) }}">Attend</button> -->
                          <form action="{{ URL::to('/attend/'.$status.'/'.$data->id) }}" method="POST">
                              @csrf
                              @method('POST')
                              <button type="button" class="btn btn-primary btn-attend">
                                Attend
                              </button>
                          </form>
                          <!-- <button type="button" class="btn btn-primary btn-attend" data-url="{{ URL::to('/attend/'.$status.'/'.$data->id) }}">
                                Attend
                          </button> -->
                        @else
                          <button type="button" class="btn btn-success btn-attend">
                                Attended
                          </button>
                        @endif

                      @else
                        <button type="button" class="btn btn-warning">Not Yet Paid</button>
                      @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script>
    $('.btn-attend').click(function(){
			swal ({
			    title: "Are you sure?",
			      text: "You won't be able to undo this.",
			      icon: "warning",
			      buttons: true,
			      dangerMode: true,
			}).then((result) => {
				if (result) {
					$(this).closest('form').submit();
				}
			})
		});

    // $('.btn-attend').click(function () {
    //   var url = $(".btn-attend").data('url');
    //   swal ({
		// 	    title: "Are you sure?",
		// 	      text: "Are you sure?",
		// 	      icon: "warning",
		// 	      buttons: true,
		// 	      dangerMode: true,
		// 	}).then((result) => {
		// 		if (result) {
    //       $.ajax({
    //           url: url,
    //           success:function(data){

    //             swal({
    //               title: "Successfull!",
    //               text: "Thank You For Attending The Event",
    //               icon: "success",
    //               button: "Close",
    //             });
    //           }
    //       });
		// 		}
		// 	})

    // });
</script>
