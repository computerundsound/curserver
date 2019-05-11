{extends file='standard_wrap.tpl'}
{block name=content}
    <div class="row">
        <div class="col">

            <form action="{$standards.php_self}" method="post" enctype="application/x-www-form-urlencoded"
                  name="form_host_action">

                <input type="hidden" name="action" value="something"/>
                <input type="hidden" name="action_id" value="nothing"/>

            </form>

            {if $diffToWindowsHostfile}
                <div class="alert alert-danger">
                    <p>Your content from your real windows Hostfile differs from the content that is created by this
                       tool!</p>

                    <p>Please update your Windows host-file {$smarty.const.HOST_FILE_PATH}</p>

                    <p>For this, you have edit the host-file with administrator rights.</p>

                </div>
            {/if}


            <p>All Templates run on the <strong>port {$smarty.const.CU_PORT}</strong> We strongly recommend not to
               change this!</p>

            <p>

                <button type="button" class="btn btn-default" id="hostmask_add_btn">
                    <i class="fas fa-plus"></i> New Host
                </button>
                <button type="button" id="hostmask_process_vhostfile_btn" class="btn btn-danger"><i
                            class="fas fa-save"></i> Process - write vhost-File (Xampp)
                </button>
            </p>

            {if $update_msg === true}
                <div class="jumbotron">

                    <div class="alert alert-primary">
                        <p>You have updated your hosts...</p>
                        <ul>
                            <li>Edit your Windows host-File</li>
                            <li>Restart Apache (Xampp)</li>
                        </ul>
                    </div>
                </div>
            {/if}


            {if $hostfile_content !== ''}
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="text-info" for="hostfile_content">
                                <button class="btn btn-bd-primary" type="button">Your hostfile content: (click to
                                                                                 select):
                                </button>
                            </label>
                            <textarea name="hostfile_content"
                                      class="form-control"
                                      id="hostfile_content"
                                      cols="30"
                                      rows="10">{$hostfile_content|escape}</textarea>
                        </div>
                    </div>
                </div>
            {/if}

        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <form class="form-inline" role="form" name="form_hostlister_sort_handler" method="post">
                <div class="form-group">
                    <label class="control-label mr-3" for="hostlist_sort_handler">Sort by: </label>

                    <select name="sort_handler_arrayhostlister[item]"
                            id="hostlist_sort_handler"
                            class="form-control"
                            onchange="document.form_hostlister_sort_handler.submit()">
                        {html_options options=$hostlist_sorter_options selected=$hostlist_sort_handler_item}
                    </select>
                </div>
            </form>

        </div>

        <div class="col-md-6">

            <form class="form-inline" role="form" name="form_hostlister_search_handler" method="get">

                <div class="form-group ml-auto">
                    <label class="mr-3" for="hostlist_search_handler">Search for: </label>
                    <input name="search_handler"
                           id="hostlist_search_handler"
                           class="form-control form-control-lg"
                           onchange="document.form_hostlister_search_handler.submit()"
                           value="{$searchHandlerString}">

                </div>
            </form>


        </div>

    </div>
    <div class="row">
        <div class="col">

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Host</th>
                        <th>Path</th>
                        <th>Comment</th>
                        <th>&nbsp;</th>
                    </tr>

                    </thead>
                    <tbody>
                    {foreach $hosts->getHostListArray() as $host}
                        <tr class="table_show_a">
                            <td>

                                <dl>
                                    <dt><a href="http://{$host->getFullDomain()}"
                                           target="_blank">{$host->getFullDomain()}</a></dt>
                                    <dd>{$host->getIp()}</dd>
                                </dl>

                            </td>
                            <td>
                                {$host->getVhostDir()}<br>
                                {$host->getVhostHtdocs()}
                            </td>
                            <td>
                                {$host->getComment()|escape|nl2br}
                            </td>
                            <td>
                                <i class="fas fa-edit cuHoverPointer"
                                   data-action='edit_host'
                                   data-action_id='{$host->getId()}'>&nbsp;
                                </i>
                                <i class="fas fa fa-trash-alt text-danger cuHoverPointer"
                                   data-action='kill_host'
                                   data-action_id='{$host->getId()}'
                                   data-host_name='{$host->getFullDomain()}'>

                                </i>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    {*Modal for edit*}
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="meinGroßesModalLabel"
         aria-hidden="true" id="modal-mask-host-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 20px;">


                <h3><span id="hostmask_headline"></span> <span id="editmask_hosts"></span></h3>

                <form class="form-horizontal" role="form" id="form_host_data" name="form_host_data"
                      action="{$standards.php_self}" method="post">

                    <div class="form-group">
                        <label for="hostmask_subdomain" class="col-sm-2 control-label">Subdomain</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_subdomain" name="subdomain">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hostmask_domain" class="col-sm-2 control-label">Domain</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_domain" name="domain">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hostmask_tld" class="col-sm-2 control-label">Tld</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_tld" name="tld">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hostmask_ip" class="col-sm-2 control-label">IP</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_ip" name="ip">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hostmask_vhost_dir" class="col-sm-2 control-label">VHost - Dir</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_vhost_dir" name="vhost_dir">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hostmask_vhost_htdocs" class="col-sm-2 control-label">VHost - htdocs</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hostmask_vhost_htdocs" name="vhost_htdocs">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="hostmask_comment" class="col-sm-2 control-label">Comment</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" id="hostmask_comment" name="comment"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary host_action_btn"
                                    id="hostmask_submit_btn"></button>
                        </div>
                    </div>

                    <input type="hidden" name="action" id="hostmask_action"/>
                    <input type="hidden" name="action_id" id="hostmask_action_id"/>

                </form>

            </div>
        </div>
    </div>
{/block}