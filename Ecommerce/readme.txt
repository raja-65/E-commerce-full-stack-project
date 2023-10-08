TITLE:E-Commerce Web Portal 
       --------------------

SuperAdmin
    Maintain platform
    Promote Website
    Manage Users
    Manage Customer Service
    Authentication - MVP

        Signup
            UI(HTML+CSS)
                username
                password
                retype-password
                user_type(vendor|customer)
                Single Signon
            JS
                Check both the password and retype password is same
                make sure all the input fields are mandatory

            BackEnd
                DB
                    user table
                        userid(AI primary key),username,password,user_type,created_date
                PHP
                    Receive all the input fields via POST
                    Validate the retype password = password
                    hash the password and store as cipher_text
                    insert all the (username,cipher_text,user_type) into user table
                    if insert is success redirect to login page
                    else show error
        Signin
            UI
                username
                password

            BE
                PHP
                    get the username and password
                    hash the password
                    search the user table with username and hashed password 
                    if any match found check the user_type and redirect to that corresponding Home Page
                    else show "Invalid Credentials"
        
        Authguard         
            BE
                After login store all the user info in session
                every server request will check the authorization of the user, based on session
                display the user info in screen along with logout button
                on logot destroy the session and redirect to login



Vendor(s)
    Manage products - MVP
        Add 
            UI
                name,item_code,price,details,image,category,availability
                TASK
                    find how to upload files using html form

            BE

                DB
                    product table
                        pid,name,price,details,image_path,item_code,category,availability,uploaded_by,created_date

                PHP
                    collect the all the basic prod details in $_POST
                    collect the uploaded image details in $_FILES
                    create a unique name for the image file and move it to a server folder
                    store all the product details into the product table along with the image folder path
        View
        Edit
        Delete
    Manage Orders - MVP
        View 
        Deliver
    Manage Customer Refunds
    Festival Offers

    
Customer(s)
    View products - MVP
    Search/filter/Compare Products 
    Cart Management - MVP
        Add 
        View
        Delete
    Place Order - MVP
    Track Order
    Rating/Review
    Return/Exchange

    MVP Model
    ---------