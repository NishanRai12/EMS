<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .container {
            margin-top: 2%;
            height: 500px;
            overflow: hidden;
            border: 1px solid #333;
            position: relative;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            width: 70%;
        }

        .content-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .content {
            margin-top: 30px;
            min-width: 100%;
            height: 200px;
            display: flex;
            flex-direction: column;
            margin-left: 130px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #3260a8;
            color: white;
            border-radius: 5px;
        }

        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            color: #3260a8;
            font-size: 40px;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="content-wrapper">
        <div class="content">
            <h1>ADD CATEGORY</h1>
            <form action="{{route('category.getDataCat')}}" method="POST">
                @csrf
                <div style="display: flex; align-items: center;">
                    <input style="width: 150px; margin-right: 10px;" type="text" placeholder="New Category" name="cat_name" id="new_cat">
                    <button style="background: none; border: none;color: #1f2937" type="button" onclick="newCat()"><i class="fa-solid fa-square-plus"></i></button>
                    <br>
                    @error('cat_name')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit">Submit</button>
            </form>

            <div id="new_category_container"></div> <!-- Container for dynamic categories -->

        </div>
    </div>
</div>

<script>
    // Initialize an array to store categories globally
    let categories = [];

    // Function to handle adding a new category
    function newCat() {
        const newCategory = document.getElementById('new_cat').value.trim();

        if (newCategory === '') {
            alert('Category name cannot be empty!');
        }else if(categories.includes(newCategory)){
            alert('New Category Already placed')
        }else {
            // Create a new checkbox for the category
            const newInput = document.createElement("input");
            newInput.type = "checkbox";
            newInput.checked = true;

            // Create the label for the new category
            const label = document.createElement("label");
            label.textContent = newCategory;

            // Create a div to hold the checkbox and label
            const container = document.createElement("div");
            container.classList.add("category-container");
            container.appendChild(newInput);
            container.appendChild(label);

            // Append the new category container to the existing container
            document.getElementById("new_category_container").appendChild(container);

            // Add the new category to the categories array
            categories.push(newCategory);
            console.log(categories); // Log the updated array of categories

            // Clear the input field after adding the category
            document.getElementById('new_cat').value = '';

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "newCategory";
            input.value = categories;
            document.querySelector('form').appendChild(input)
        }
    }
</script>

</body>
</html>
