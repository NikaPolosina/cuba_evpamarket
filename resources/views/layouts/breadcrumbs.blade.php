
<div class="bread">
    <div class="cl-sm-10 col-sm-offset-1 sm">
        {!! $breadcrumbs!!}

    </div>

</div>


<style>
    .breadcrumbs {
        list-style: none;
        overflow: hidden;
    }

    .breadcrumbs li {
        float: left;
    }

    .bread>ul {
        line-height: 30px;
    }
    .bread{
        overflow: hidden;
        width: 100%;
        margin-bottom: 5px;
        position: relative;
        height: 36px;
        border-bottom: 1px solid #e9e9e9;
        background-color: rgb(245, 245, 245);
        font-size: 14px;
    }
    .bread .sm>ul>li>span{
        line-height: 36px;
    }
</style>