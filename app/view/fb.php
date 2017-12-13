<?php echo $header;?>
<style>
    #components{
        min-height: 600px;
    }
    #target{
        min-height: 200px;
        border: 1px solid #ccc;
        padding: 5px;
    }
    #target .component{
        border: 1px solid #fff;
    }
    #temp{
        width: 500px;
        background: white;
        border: 1px dotted #ccc;
        border-radius: 10px;
    }

    .popover-content form {
        margin: 0 auto;
        width: 213px;
    }
    .popover-content form .btn{
        margin-right: 10px
    }
    #source{
        min-height: 500px;
    }
</style>
<link href="/static/fb/bootstrap-responsive.css" rel="stylesheet">
<div class="container content" style="width: 100%">
    <div class="row clearfix">
        <div class="span6">
            <div class="clearfix">
                <h2>创建数据表</h2>
                <hr>
                <div id="build">
                    <form id="target" class="form-horizontal">
                        <fieldset>
                            <div id="legend" class="component" rel="popover" title="Form Title" trigger="manual"
                                 data-content="
                    <form class='form'>
                      <div class='controls'>
                        <label class='control-label'>Title</label> <input class='input-large' type='text' name='title' id='text'>
                        <hr/>
                        <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                      </div>
                    </form>"
                            >
                                <legend class="valtype" data-valtype="text">表单名</legend>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="span6">
            <h2>拖拽下面的组件到左侧</h2>
            <hr>
            <div class="tabbable">
                <ul class="nav nav-tabs" id="navtab">
                    <li class="active"><a href="#1" data-toggle="tab">输入框</a></li>
                    <li class><a href="#2" data-toggle="tab">下拉框</a></li>
                    <li class><a href="#3" data-toggle="tab">复选 / 单选</a></li>
                    <li class><a href="#4" data-toggle="tab">文件 / 按钮</a></li>
                </ul>
                <form class="form-horizontal" id="components">
                    <fieldset>
                        <div class="tab-content">

                            <div class="tab-pane active" id="1">

                                <div class="control-group component" data-type="text" rel="popover" title="Text Input" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <label class='control-label'>Placeholder</label> <input type='text' name='placeholder' id='placeholder'>
                          <label class='control-label'>Help Text</label> <input type='text' name='help' id='help'>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >

                                    <!-- Text input-->
                                    <label class="control-label valtype" for="input01" data-valtype='label'>文本框</label>
                                    <div class="controls">
                                        <input type="text" placeholder="placeholder" class="input-xlarge valtype" data-valtype="placeholder" >

                                    </div>
                                </div>




                                <div class="control-group component" rel="popover" title="Search Input" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >

                                    <!-- Textarea -->
                                    <label class="control-label valtype" data-valtype="label">文本域</label>
                                    <div class="controls">
                                        <div class="textarea">
                                            <textarea type="" class="valtype" data-valtype="checkbox" /> </textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="2">

                                <div class="control-group component" rel="popover" title="Search Input" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <label class='control-label'>Options: </label>
                          <textarea style='min-height: 200px' id='option'> </textarea>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >

                                    <!-- Select Basic -->
                                    <label class="control-label valtype" data-valtype="label">单选下拉</label>
                                    <div class="controls">
                                        <select class="input-xlarge valtype" data-valtype="option">
                                            <option>Enter</option>
                                            <option>Your</option>
                                            <option>Options</option>
                                            <option>Here!</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="control-group component" rel="popover" title="Search Input" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <label class='control-label'>Options: </label>
                          <textarea style='min-height: 200px' id='option'></textarea>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >

                                    <!-- Select Multiple -->
                                    <label class="control-label valtype" data-valtype="label">复选下拉</label>
                                    <div class="controls">
                                        <select class="input-xlarge valtype" multiple="multiple" data-valtype="option">
                                            <option>Enter</option>
                                            <option>Your</option>
                                            <option>Options</option>
                                            <option>Here!</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="3">


                                <div class="control-group component" rel="popover" title="Multiple Radios" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <label class='control-label'>Group Name Attribute</label> <input class='input-large' type='text' name='name' id='name'>
                          <label class='control-label'>Options: </label>
                          <textarea style='min-height: 200px' id='radios'></textarea>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >
                                    <label class="control-label valtype" data-valtype="label">单选</label>
                                    <div class="controls valtype" data-valtype="radios">

                                        <!-- Multiple Radios -->
                                        <label class="radio">
                                            <input type="radio" value="Option one" name="group" checked="checked">
                                            正常
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="Option two" name="group">
                                            关闭
                                        </label>
                                    </div>

                                </div>

                                <div class="control-group component" rel="popover" title="Inline Checkboxes" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <textarea style='min-height: 200px' id='inline-checkboxes'></textarea>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >
                                    <label class="control-label valtype" data-valtype="label">多选</label>

                                    <!-- Multiple Checkboxes -->
                                    <div class="controls valtype" data-valtype="inline-checkboxes">
                                        <label class="checkbox inline">
                                            <input type="checkbox" value="1"> 1
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" value="2"> 2
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" value="3"> 3
                                        </label>
                                    </div>

                                </div>



                            </div>

                            <div class="tab-pane" id="4">
                                <div class="control-group component" rel="popover" title="File Upload" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >
                                    <label class="control-label valtype" data-valtype="label">文件</label>

                                    <!-- File Upload -->
                                    <div class="controls">
                                        <input class="input-file" id="fileInput" type="file">
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="Search Input" trigger="manual"
                                     data-content="
                      <form class='form'>
                        <div class='controls'>
                          <label class='control-label'>Label Text</label> <input class='input-large' type='text' name='label' id='label'>
                          <label class='control-label'>Button Text</label> <input class='input-large' type='text' name='label' id='button'>
                          <label class='control-label' id=''>Type: </label>
                          <select class='input' id='color'>
                            <option id='btn-default'>Default</option>
                            <option id='btn-primary'>Primary</option>
                            <option id='btn-info'>Info</option>
                            <option id='btn-success'>Success</option>
                            <option id='btn-warning'>Warning</option>
                            <option id='btn-danger'>Danger</option>
                            <option id='btn-inverse'>Inverse</option>
                          </select>
                          <hr/>
                          <button class='btn btn-info'>Save</button><button class='btn btn-danger'>Cancel</button>
                        </div>
                      </form>"
                                >
                                    <label class="control-label valtype" data-valtype="label">提交</label>

                                    <!-- Button -->
                                    <div class="controls valtype"  data-valtype="button">
                                        <button class='btn btn-success'>提交</button>
                                    </div>
                                </div>
                            </div>


                    </fieldset>
                </form>
            </div>
        </div> <!-- row -->
    </div> <!-- /container -->

    <script src="/static/fb/bs.js"></script>
    <script src="/static/fb/fb.js"></script>

