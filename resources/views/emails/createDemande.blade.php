<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- Facebook sharing information tags -->
    <meta property="og:title" content="*|MC:SUBJECT|*" />

    <title>*|MC:SUBJECT|*</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVuJ8zI1I-V9ckmycKWAbNRJmcTzs7nZE"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.googlemap/1.5/jquery.googlemap.js"></script>

</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
        <tr>
            <td align="center" valign="top">
                <!-- // Begin Template Preheader \\ -->
                <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                    <tr>
                        <td valign="top" class="preheaderContent">

                            <!-- // Begin Module: Standard Preheader \ -->
                            <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top">
                                        <div mc:edit="std_preheader_content">
                                            Use this area to offer a short teaser of your email's content. Text here will show in the preview area of some email clients.
                                        </div>
                                    </td>
                                    <!-- *|IFNOT:ARCHIVE_PAGE|* -->
                                    <td valign="top" width="190">
                                        <div mc:edit="std_preheader_links">
                                            Is this email not displaying correctly?<br /><a href="*|ARCHIVE|*" target="_blank">View it in your browser</a>.
                                        </div>
                                    </td>
                                    <!-- *|END:IF|* -->
                                </tr>
                            </table>
                            <!-- // End Module: Standard Preheader \ -->

                        </td>
                    </tr>
                </table>
                <!-- // End Template Preheader \\ -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                    <tr>
                        <td align="center" valign="top">
                            <!-- // Begin Template Header \\ -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                <tr>
                                    <td class="headerContent">

                                        <!-- // Begin Module: Standard Header Image \\ -->
                                        <img src="http://107.170.211.184/wp-content/uploads/2014/08/word_cloud_language.jpg" style="max-width:600px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                        <!-- // End Module: Standard Header Image \\ -->

                                    </td>
                                </tr>
                            </table>
                            <!-- // End Template Header \\ -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- // Begin Template Body \\ -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                <tr>
                                    <td valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td valign="top" class="bodyContent">

                                                    <!-- // Begin Module: Standard Content \\ -->
                                                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td valign="top">
                                                                <div mc:edit="std_content00">
                                                                    <h2 class="h2">Your Request Details</i></h2>

                                                                    <table>
                                                                        <hr>

                                                                        <strong>Title : </strong> {{$demande->titre}}
                                                                        <p style="margin:10px;">
                                                                            {{$demande->contenu}}
                                                                        </p>
                                                                        <hr>
                                                                        <strong>Start Event : </strong>{{$demande->dateEvent}}
                                                                        <br/>
                                                                        <strong>End Event : </strong>{{$demande->dateEndEvent}}
                                                                        <hr>
                                                                    </table>
                                                                    <h4 style="margin-top:5px;">Client details</h4>
                                                                    <table>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Client :</strong>
                                                                            </td>
                                                                            <td>
                                                                                {{$client->nom}} {{$client->prenom}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Email :</strong>
                                                                            </td>
                                                                            <td>
                                                                                {{$client->email}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>mobile :</strong>
                                                                            </td>
                                                                            <td>
                                                                                {{$client->tel_portable}}
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top">
                                                                <div id="map" style="width: 100%; height: 200px;"></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // End Module: Standard Content \\ -->

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- // Begin Sidebar \\  -->
                                    <td valign="top" width="200" id="templateSidebar">
                                        <table border="0" cellpadding="0" cellspacing="0" width="200">
                                            <tr>
                                                <td valign="top" class="sidebarContent">

                                                    <!-- // Begin Module: Social Block with Icons \\ -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td valign="top" style="padding-top:10px; padding-right:20px; padding-left:20px;">
                                                                <table border="0" cellpadding="0" cellspacing="4">
                                                                    <tr mc:hideable>
                                                                        <td align="left" valign="middle" width="16">
                                                                            <img src="http://gallery.mailchimp.com/653153ae841fd11de66ad181a/images/sfs_icon_facebook.png" style="margin:0 !important;" />
                                                                        </td>
                                                                        <td align="left" valign="top">
                                                                            <div mc:edit="sbwi_link_one">
                                                                                <a href="*|FACEBOOK:PROFILEURL|*">Friend on Facebook</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr mc:hideable>
                                                                        <td align="left" valign="middle" width="16">
                                                                            <img src="http://gallery.mailchimp.com/653153ae841fd11de66ad181a/images/sfs_icon_twitter.png" style="margin:0 !important;" />
                                                                        </td>
                                                                        <td align="left" valign="top">
                                                                            <div mc:edit="sbwi_link_two">
                                                                                <a href="*|TWITTER:PROFILEURL|*">Follow on Twitter</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr mc:hideable>
                                                                        <td align="left" valign="middle" width="16">
                                                                            <img src="http://gallery.mailchimp.com/653153ae841fd11de66ad181a/images/sfs_icon_forward.png" style="margin:0 !important;" />
                                                                        </td>
                                                                        <td align="left" valign="top">
                                                                            <div mc:edit="sbwi_link_three">
                                                                                <a href="*|FORWARD|*">Forward to a Friend</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // End Module: Social Block with Icons \\ -->

                                                    <!-- // Begin Module: Top Image with Content \\ -->
                                                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                        <tr mc:repeatable>
                                                            <td valign="top">
                                                                <img src="https://flan.csusb.edu/images/world.png" style="max-width:160px;" mc:label="image" mc:edit="tiwc200_image00" />
                                                                <div mc:edit="tiwc200_content00">
                                                                    <p></p>
                                                                    <h4 class="h4">Heading 4</h4>
                                                                    <strong>Repeatable content blocks:</strong> Repeatable sections are noted with plus and minus signs so that you can add and subtract content blocks. You can also <a href="http://www.mailchimp.com/kb/article/how-do-i-work-with-repeatable-content-blocks" target="_blank">get a little fancy</a>: repeat blocks and remove all text to make image "gallery" sections, or do the opposite and remove images for text-only blocks!
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // End Module: Top Image with Content \\ -->
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- // End Sidebar \\ -->
                                </tr>
                            </table>
                            <!-- // End Template Body \\ -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- // Begin Template Footer \\ -->
                            <table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter">
                                <tr>
                                    <td valign="top" class="footerContent">

                                        <!-- // Begin Module: Standard Footer \\ -->
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                            <tr>
                                                <td colspan="2" valign="middle" id="social">
                                                    <div mc:edit="std_social">
                                                        &nbsp;<a href="*|TWITTER:PROFILEURL|*">follow on Twitter</a> | <a href="*|FACEBOOK:PROFILEURL|*">friend on Facebook</a> | <a href="*|FORWARD|*">forward to a friend</a>&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" width="350">
                                                    <div mc:edit="std_footer">
                                                        <em>Copyright &copy; *2016* *Words and co*, All rights reserved.</em>
                                                        <br />
                                                        *|IFNOT:ARCHIVE_PAGE|* *|LIST:DESCRIPTION|*
                                                        <br />
                                                        <strong>Our mailing address is:</strong>
                                                        <br />
                                                        *wordandco.oxford.com* *|END:IF|*
                                                    </div>
                                                </td>
                                                <td valign="top" width="190" id="monkeyRewards">
                                                    <div mc:edit="monkeyrewards">
                                                        *|IF:REWARDS|* *|HTML:REWARDS|* *|END:IF|*
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" valign="middle" id="utility">
                                                    <div mc:edit="std_utility">
                                                        &nbsp;<a href="*|UNSUB|*">unsubscribe from this list</a> | <a href="*|UPDATE_PROFILE|*">update subscription preferences</a>&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // End Module: Standard Footer \\ -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // End Template Footer \\ -->
                        </td>
                    </tr>
                </table>
                <br />
            </td>
        </tr>
    </table>
</center>
<script type="text/javascript">
    $(function() {
        $("#map").googleMap();
        $("#map").addMarker({
            coords: [{{$adresse->lat}}, {{$adresse->long}}], // GPS coords
            url: 'http://www.tiloweb.com', // Link to redirect onclick (optional)
            id: 'marker1' // Unique ID for your marker
        });
    })
</script>
</body>
</html>