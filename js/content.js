const getContent = () => {
    const wrapper = $('#wrapper');
    // wrapper.empty();
    $.get( "controller/getcontent.php", d => {
        if(d.length > 0) {
            $.parseJSON(d).map(blog => {
                    console.log(blog);
                    wrapper.append(`<div><h3>${blog.title}</h3><h6>Created by: ${blog.user.username}</h6>
                    <time datetime="${blog.date_update}">${blog.date_update}</time><p>${blog.content}</p></div>`);
                });
            } else  {
                wrapper.append("<div>No blogs <input type='button' value='Create Tables' id='btnCreate' /><input type='button' value='Create Test Data' id='btnTestData' /> </div>");
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
$(document).on('click', '#btnTestData', function (e) {
    e.preventDefault();
    $.get("controller/createtestdata.php", getContent());
});