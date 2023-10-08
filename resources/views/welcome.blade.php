
<form action="{{ route('search') }}">
    <div class="input-group">
        <input type="text" class="form-control name-input" name="q" placeholder="Search TV Shows">
        <div class="input-group-append">
            <button class="btn btn-primary" onclick="getResponse(event);">Search</button>
        </div>
    </div>
</form>

<div id="results"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

        let getResponse = (event) => {
            event.preventDefault()
            let q = $('.name-input').val();
            let resultsId = $('#results');

            let searchUrl = '{{ route('search') }}' + '?q=' + encodeURIComponent(q);

            $.ajax({
                type: 'GET',
                url: searchUrl,
                data: {
                    q: q,
                },
                success: function (response) {
                    resultsId.empty();
                    resultsId.append(response);

                    window.history.pushState({}, null, searchUrl);

                },
                error: function (xhr) {
                    resultsId.empty();
                    let errorResponse = JSON.parse(xhr.responseText);
                    let statusCode = xhr.status;

                    resultsId.append("Status Code: " + statusCode + ", Message: " + errorResponse.error.error);

                    window.history.pushState({}, null, searchUrl);
                }
            });
        }
</script>
