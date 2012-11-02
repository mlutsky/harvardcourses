</ul>
        </div>
        <div data-role="footer" data-position="fixed">
            <div data-role="navbar">
                <ul>
                <?php if($selected == 'browsing'): ?>
                    <li><a id="browse-icon" data-icon="custom" href="/courses/" class="ui-btn-active ui-state-persist">Browse</a></li>
                    <li><a id="shopping-icon" data-icon="custom" href="/courses/shopping" data-ajax="false">Shopping</a></li>
                    <li><a id="taking-icon" data-icon="custom" href="/courses/taking" data-ajax="false">Taking</a></li>
                <?php elseif($selected == 'shopping'): ?>
                    <li><a id="browse-icon" data-icon="custom" href="/courses/" >Browse</a></li>
                    <li><a id="shopping-icon" data-icon="custom" href="#" class="ui-btn-active ui-state-persist" data-ajax="false">Shopping</a></li>
                    <li><a id="taking-icon" data-icon="custom" href="/courses/taking" data-ajax="false">Taking</a></li>
                <?php elseif($selected == 'taking'): ?>
                     <li><a id="browse-icon" data-icon="custom" href="/courses/" >Browse</a></li>
                    <li><a id="shopping-icon" data-icon="custom" href="/courses/shopping/"  data-ajax="false">Shopping</a></li>
                    <li><a id="taking-icon" data-icon="custom" href="#" class="ui-btn-active ui-state-persist" data-ajax="false">Taking</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>


    </body>
</html>
