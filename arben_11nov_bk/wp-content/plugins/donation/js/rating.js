function getExistdata()
{
        x=document.forms["rating_comment_form"]["finalrating"].value;
        if(x != null || x !="")
        {
                for(var j=1;j<=x;j++)
                {
                        document.getElementById('img_'+j).src="wp-content/plugins/ratings/images/star3.jpg";	
                }
        }
}

function comment_fun()
{
        var y=document.forms["rating_comment_form"]["finalrating"].value;
        if (y==null || y=="")
        {
        alert("Please select rating");
        return false;
        }
        
        var x=document.forms["rating_comment_form"]["comment"].value;
        if (x==null || x=="")
        {
        alert("Please Comment");
        return false;
        }
}

function rating_fun(myval)
{
        document.getElementById('finalrating').value=myval;
        for(var i=1;i<=5;i++)
        {
                document.getElementById('img_'+i).src="wp-content/plugins/ratings/images/star2.jpg";
        }
        for(var i=1;i<=myval;i++)
        {
                document.getElementById('img_'+i).src="wp-content/plugins/ratings/images/star3.jpg";
        }
        
}
