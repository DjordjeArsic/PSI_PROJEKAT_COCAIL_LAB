<html>
    <head>
        <title>Cocktail Lab</title>
    </head>
    <body>
        <table>
            <tr>
                <td>
                    <?php echo ' <a href='.site_url("Admin/index").' id="pretraga">Home</a>';?>
                </td>
                <td>
                    <?php echo ' <a href='.site_url("Admin/reportovaniRecepti").' id="reportovaniRecepti">ReportovaniRecepti</a>';?>
                </td>
                <td>
                    <?php echo ' <a href='.site_url("Admin/mojiKokteli").' id="mojiRecepti">MojiRecepti</a>';?>
                </td>
                <td>
                    <?=anchor('Nalog/logOut', 'Log out');?>
                </td>
                <td>
                    <?php echo ' <a href='.site_url("Korisnik/postaviRecept").' id="postaviRecept">Postavi recept</a>';?>
                </td>
            </tr>
        </table>
      <hr>