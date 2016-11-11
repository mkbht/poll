		</div>
	</div> <!-- container -->
</main>
<footer></footer>
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<script src="../dist/js/vendor/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../dist/js/vendor/video.js"></script>
<script src="../dist/js/flat-ui.min.js"></script>
<script src="../dist/js/jquery.bootgrid.min.js"></script>
<script src="../dist/js/jquery.bootgrid.fa.min.js"></script>
<script src="../dist/js/script.js"></script>
<script type="text/javascript">
			    //datagrid
    function init()
    {
        var grid = $("#grid").bootgrid({
            formatters: {
                "link": function(column, row)
                {
                    return "<button data-row-id=\"" + row.id + "\" class=\"btn btn-xs btn-danger command-delete\"><i class='fa fa-trash'></i></button>";
                }
            },
            rowCount: [10, 25, 50, 75, 100],
            rowSelect: true,
            caseSensitive: false
        }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {

    }).end().find(".command-delete").on("click", function(e)
    {
        var rows = Array();
        rows[0] = $(this).data("row-id");
        $("#grid-command-buttons").bootgrid('remove', rows);
        var c = confirm("Are you sure to delete?");
        if(c == true) {
            $.get('deleteUser.php?id='+$(this).data("row-id"), function(data) {
                if(data == "User deleted successfully")
                 $("#grid").bootgrid('remove', rows);
                $("#message").html('<div class="alert alert-info">'+data+'</div>');
                
            });
        }
    });
});
    }
    
    init();

    function initPoll()
    {
        var grid = $("#grid-poll").bootgrid({
            formatters: {
                "link": function(column, row)
                {
                    return "<a href=\"../vote.php?id=" + row.id + "\" class=\"btn btn-xs btn-inverse\">View</a> <button data-row-id=\"" + row.id + "\" class=\"btn btn-xs btn-danger command-delete\"><i class='fa fa-trash'></i></button>";
                }
            },
            rowCount: [10, 25, 50, 75, 100],
            rowSelect: true,
            caseSensitive: false
        }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {

    }).end().find(".command-delete").on("click", function(e)
    {
        var rows = Array();
        rows[0] = $(this).data("row-id");
        $("#grid-command-buttons").bootgrid('remove', rows);
        var c = confirm("Are you sure to delete?");
        if(c == true) {
            $.get('deletePoll.php?id='+$(this).data("row-id"), function(data) {
                if(data == "Poll deleted successfully")
                 $("#grid-poll").bootgrid('remove', rows);
                $("#message").html('<div class="alert alert-info">'+data+'</div>');
                
            });
        }
    });
});
    }
    
    initPoll();
</script>