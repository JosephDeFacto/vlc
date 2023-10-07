
<form action="{{ route('search') }}">
    <div class="input-group">
        <input type="text" class="form-control name-input" name="q" placeholder="Search TV Shows">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </div>
</form>

<div id="results"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-primary').on('click', function (event) {
            event.preventDefault();
            let q = $('.name-input').val();
            let resultsId = $('#results');

            $.ajax({
                type: 'GET',
                url: '{{ route('search') }}',
                data: {
                    q: q,
                },
                success: function (response) {
                    resultsId.empty();
                    resultsId.append(response);
                },
                error: function (xhr) {
                    resultsId.empty();
                    let err = JSON.parse(xhr.responseText);
                    resultsId.append(err.error);
                }
            })
        })
    });
</script>
