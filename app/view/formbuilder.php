

<?php echo $header;?>
<link href="/static/FormBuilder/assets/css/lib/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/static/FormBuilder/assets/css/custom.css" rel="stylesheet">
<div class="content">
    <div class="row clearfix">
        <!-- Building Form. -->
        <div class="span6">
            <div class="clearfix">
                <h2>你的表单</h2>
                <hr>
                <div id="build">
                    <form id="target" class="form-horizontal">
                    </form>
                </div>
            </div>
        </div>
        <!-- / Building Form. -->

        <!-- Components -->
        <div class="span6">
            <h2>拖放组件</h2>
            <hr>
            <div class="tabbable">
                <ul class="nav nav-tabs" id="formtabs">
                    <!-- Tab nav -->
                </ul>
                <form class="form-horizontal" id="components">
                    <fieldset>
                        <div class="tab-content">
                            <!-- Tabs of snippets go here -->
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- / Components -->

    </div>

</div> <!-- /container -->

<script data-main="/static/FormBuilder/assets/js/main.js" src="/static/FormBuilder/assets/js/lib/require.js" ></script>
</body>
</html>
