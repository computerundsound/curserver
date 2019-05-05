{extends file='standard_wrap.tpl'}
{block name=content}
    <!--suppress HtmlFormInputWithoutLabel -->
    <div class="row">
        <div class="col-md-12">

            <h2>Change content from Database-tables</h2>
            <h3>Be Carefully!!!</h3>

            <form action="_temp/replaceInMysqlTable.php" method="get">

                <div class="form-group">
                    <label for=""></label>
                    <input type="text"
                           class="form-control"
                           name="tableName"
                           placeholder="Table Name"
                           value="{$replaceData.tableName}">
                </div>

                <div class="form-group">
                    <label for=""></label>
                    <input type="text"
                           class="form-control"
                           name="colName"
                           placeholder="Col Name"
                           value="{$replaceData.colName}">
                </div>


                <div class="form-group">
                    <label for=""></label>
                    <input type="text"
                           class="form-control"
                           name="replace_this"
                           placeholder="replace (RegEx) this"
                           value="{$replaceData.replaceThis}">
                </div>

                <div class="form-group">
                    <label for=""></label>
                    <input type="text"
                           class="form-control"
                           name="replace_by_this"
                           placeholder="replace (RegEx) by this"
                           value="{$replaceData.replaceByThis}">
                </div>

                <button type="submit" class="btn btn-default">Submit</button>

            </form>

        </div>

    </div>
    <div class="row">
        <div class="col-md-12">

            <h3>Executed Queries:</h3>

            <pre>
{foreach $queries as $query}{$query}
{/foreach}</pre>

        </div>
    </div>
{/block}