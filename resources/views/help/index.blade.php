<div id="helpcentre" class="modal modal-fixed-footer" >
    <div class="modal-header" style="padding:24px 24px 5px 24px;">
        <h4>Help Centre</h4>
        <hr>
    </div>
    <div class="row" style="position: relative; height: calc(100% - 56px - 90px); ">
        <div class="col s12 m4" style="position: relative; top: 0px; left: 15px; z-index: 1; height:100%;  overflow-y:scroll">
            <div class="collection with-header" id="help-top" style="overflow-y:scroll;">
                <div class="collection-header"><h4>Contents</h4></div>
                <a href="#help-dashboard" class="collection-item">Dashboard</a>
                <a href="#help-news-add" class="collection-item">Add News, Blogs, Galleries</a>
                <a href="#help-soon" class="collection-item">Add Events</a>
                <a href="#help-soon" class="collection-item">Add Notifications</a>
                <a href="#help-soon" class="collection-item">Add Letters/Documents</a>
                <a href="#help-soon" class="collection-item">Add/Update/Sort Staff List</a>
                <a href="#help-soon" class="collection-item">Pin items</a>
                <a href="#help-upload" class="collection-item">Uploading Items</a>
            </div>
        </div>
        <div class="modal-content" style="float: right; height: auto;">
            <div class="row">
                <div class="col s12 m8 right">
                    <h4 id="help-dashboard">Dashboard</h4>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/dashboard-default-legend.png">
                    <blockquote>
                        A default Dashboard with all the categories enabled.
                    </blockquote>
                    <ol>
                        <li>Site Logo</li>
                        <li>User name, Logout</li>
                        <li>Useful Shortcuts</li>
                        <li>Open Help</li>
                        <li>Your Current location & Site Name</li>
                        <li>Available Categories (May vary depending on what's supported)</li>
                    </ol>
                    <h5>Category Panel (News, Events, Letters...)</h5>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/dashboard-news-legend.png">
                    <blockquote>
                        News Category Panel
                    </blockquote>
                    <ol>
                        <li>Category Name</li>
                        <li>List, edit, delete already existing news items</li>
                        <li>Go to the create page, where you can add a news item</li>
                        <li>List, edit, delete already existing news items sorted by their types (eg. Main News, Sports News)</li>
                    </ol>
                    <h5>Staff Panel</h5>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/dashboard-staff-legend.png">
                    <blockquote>
                        Staff Category Panel
                    </blockquote>
                    <ol>
                        <li>Category Name</li>
                        <li>Allows you to List, edit, delete already existing staff members. It gives you an option to sort your staff members as well.</li>
                        <li>Go to the staff create page, where you can add a staff members</li>
                        <li>Add new staff groups, rename and delete them</li>
                    </ol>
                    <hr>
                    <h4 id="help-news-add">Add News/Blogs/Galleries</h4>
                    <p>Adding any of these items is exactly the same. Below is instructions on how to add a news item.</p>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/news-create-legend.png">
                    <blockquote>
                        Add News Page
                    </blockquote>
                    <ol>
                        <li>Name of the Category you're adding</li>
                        <li>Your post's title</li>
                        <li>Here you can type in your main post; Instructions on the editor can be found here</li>
                        <li>Click the dropdown to choose the location of your post</li>
                        <li>Drag items over this box to upload them; More information on uploading can be found here</li>
                        <li>Gives you an access to custom publish settings; You can use it to schedule and expire items with dates of your choice; By Default items would publish immediately and never expire</li>
                        <li>Gives you a couple handy shortcuts for quick access to uploaded posts so you could edit them quickly</li>
                        <li>Open up a clean form. Once you've added a post and you're on the edit page you can use it to quickly add a new post without the need to go back to the dashboard.</li>
                        <li>Submit your new post or save changes.</li>
                    </ol>
                    <h5>Publish Settings</h5>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/publish-settings-filled-legend.png">
                    <blockquote>
                        Publish settings panel
                    </blockquote>
                    <ol>
                        <li>If you want to customize the way the Post behaves, check this box.</li>
                        <li>Allows you to choose a custom publish date. The post will not show up before the chosen date and time.</li>
                        <li>Pick a publish date</li>
                        <li>Pick a publish time</li>
                        <li>Allows you to choose a custom expire date. The post will not show up once the chosen date and time passed.</li>
                        <li>Pick a expire date</li>
                        <li>Pick a expire time</li>
                        <li>Click to hide the window</li>
                    </ol>
                    <h5>Calendar Picker</h5>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/date-calendar-legend.png">
                    <blockquote>
                        Calendar date picker
                    </blockquote>
                    <ol>
                        <li>Chosen Date</li>
                        <li>Change month and year</li>
                        <li>Selected day</li>
                        <li>Calendar days</li>
                        <li>Changes the selected day to today</li>
                        <li>Clears the calendar</li>
                        <li>Accept the changes and close</li>
                    </ol>
                    <h5>Time Picker</h5>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/date-timepicker-hour-legend.png">
                    <blockquote>
                        Time picker
                    </blockquote>
                    <ol>
                        <li>Chosen Time</li>
                        <li>Inner ring - AM hours, Outer Ring PM hours</li>
                        <li>Cancel or accept changes</li>
                    </ol>
                    <hr>
                    <h4 id="help-upload">Upload items</h4>
                    <img class="materialboxed responsive-img" src="{{url('/')}}/img/help/upload-items-legend.png">
                    <blockquote>
                        Upload items view.<br />
                        Please note, that you can upload maximum 50 files in one batch. The files cannot be bigger than 10MB each.<br />
                        Before uploading any images we recommend to resize them so they aren't wider/higher than 2000px; It is a good idea to keep the images smaller than 1MB each.<br />
                        You can upload items in batches - You can add a couple of them, then click submit, then drag some more and submit again.
                    </blockquote>
                    <ol>
                        <li>You can drag one ore more files and drop it in this area to prepare them to upload. Alternatively you can click the "Upload" button and choose the files from the file browser.</li>
                        <li>One of your uploaded items</li>
                        <li>Click to set the image as the front image. It's useful if you want to select which of the uploaded images will be your front page image.</li>
                        <li>Check all the files you'd like to remove</li>
                        <li>File's name and extension</li>
                        <li>Click Submit to apply all the changes to the uploaded files. This will Upload all the additional files you've added, remove all the unwanted files and set up your featured image.</li>
                    </ol>
                    <h4 id="help-soon">Coming soon</h4>
                    <blockquote>
                        The documentation for this help will be added soon!
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        <a href="mailto:webteam@hasla.org.uk" class="modal-action modal-close waves-effect waves-green btn-flat "><i class="material-icons left">email</i> E-Mail Webteam</a>
        <a href="{{url('/')}}/user/tutorial/reset" class="modal-action modal-close waves-effect waves-green btn-flat "><i class="material-icons left">autorenew</i> Restart Tutorial</a>
    </div>
</div>
