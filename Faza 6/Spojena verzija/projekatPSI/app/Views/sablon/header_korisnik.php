<html>
    <head>
        <title>Cocktail Lab</title>
    </head>
    <body>
        <table>
            <tr>
                <td  style='padding-left: 8px; padding-right: 8px;'>
                    <?=anchor("Korisnik/mojiKokteli", "Moji recepti")?>
                </td>
                <td>
                    <?=anchor('Nalog/logOut', 'Log out');?>
                </td>
                <td>
                    <?php echo ' <a href='.site_url("Korisnik/postaviRecept").' id="postaviRecept">Postavi recept</a>'; ?>
                </td>
            </tr>
        </table>
      <hr>
