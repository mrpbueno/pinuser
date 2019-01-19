function linkFormat(value, row, index){
    var html = '<a href="?display=pinuser&view=form&id='+value+'"><i class="fa fa-pencil-square-o"></i></a>&nbsp;';
    html += '<a class="delAction" href="?display=pinuser&action=delete&id='+value+'"><i class="fa fa-trash"></i></a>';
    return html;
}