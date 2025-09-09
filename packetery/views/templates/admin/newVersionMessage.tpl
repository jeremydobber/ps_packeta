{**
 * 2017 Zlab Solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Eugene Zubkov <magrabota@gmail.com>, RTsoft s.r.o
 *  @copyright Since 2017 Zlab Solutions
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *}
{l s='A new version of the Packeta module is available: %newVersion% (current version: %currentVersion%).' sprintf=['%newVersion%'=>$newVersion,'%currentVersion%'=>$currentVersion] d='Modules.Packetery.Newversionmessage'}
{if $downloadUrl}
    {l s='Download it' d='Modules.Packetery.Newversionmessage'} <a href="{$downloadUrl}"
        target="_blank">{l s='here' d='Modules.Packetery.Newversionmessage'}</a>.
{/if}
<br>
{if $releaseNotes}
    {l s='Change log:' d='Modules.Packetery.Newversionmessage'}<br>
    {foreach $releaseNotes as $releaseNote}
        {$releaseNoteToDisplay = truncate(nl2br($releaseNote),400, "... <a target='_blank' href='https://github.com/Zasilkovna/prestashop/releases'>{l s='Read more' d='Modules.Packetery.Newversionmessage'}</a>")}
        {$releaseNotesBr}
    {/foreach}
{/if}