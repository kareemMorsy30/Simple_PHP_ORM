<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
</head>
<body>
    <div class="container">
        <h2><span class="badge badge-warning">Jumia</span> Phone numbers</h2>
        <form id="filter-form" method="GET" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="select-country">Country</label>
                    <select class="form-control" name="country" id="select-country">
                        <option selected disabled>Select country</option>
                        <option value="237" <?php echo isset($_GET['country']) && $_GET['country'] == 237 ? 'selected' : '' ?>>Cameroon</option>
                        <option value="251" <?php echo isset($_GET['country']) && $_GET['country'] == 251 ? 'selected' : '' ?>>Ethiopia</option>
                        <option value="212" <?php echo isset($_GET['country']) && $_GET['country'] == 212 ? 'selected' : '' ?>>Morocco</option>
                        <option value="258" <?php echo isset($_GET['country']) && $_GET['country'] == 258 ? 'selected' : '' ?>>Mozambique</option>
                        <option value="256" <?php echo isset($_GET['country']) && $_GET['country'] == 256 ? 'selected' : '' ?>>Uganda</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="validate-numbers">Valid phone numbers</label>
                    <select class="form-control" id="validate-numbers">
                        <option>Valid</option>
                        <option>Invalid</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">Country code</th>
                    <th scope="col">Phone number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($customers as $index => $customer) {
                ?>
                <tr>
                    <th scope="row"><?php echo($customer->id + 1); ?></th>
                    <td><?php echo($customer->country); ?></td>
                    <td><?php echo($customer->state); ?></td>
                    <td><?php echo($customer->countryCode); ?></td>
                    <td><?php echo($customer->phoneNum); ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-5">
            </div>
            <div class="col-5">
            </div>
            <div class="col-2">
            <a href="<?php echo $previous_page_link; ?>" type="button" class="btn btn-primary <?php echo $current_page == 1 ? 'disabled' : ''; ?>">Previous</a>
                <a href="<?php echo $next_page_link; ?>" type="button" class="btn btn-primary">Next</a>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $('#select-country').change(function() {
            $('#filter-form').submit();
        });
    </script>
</body>


</html>