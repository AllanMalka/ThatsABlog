const getContent = () => {
    $.get( "controller/getcontent.php", d => {
        if(d.length > 0) {
            $('#wrapper').append("<div>Blogs found</div>");
        } else  {
            $('#wrapper').append("<div>No blogs <input type='button' value='Create Tables' id='btnCreate' /> </div>");
        }
    }
)
}
$(document).ready(() => {
    getContent();
});

$(document).on('click', '#btnCreate', function (e) {
    e.preventDefault();
    $.get("controller/createtables.php", getContent());
});