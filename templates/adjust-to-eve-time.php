<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

?>
<p class="text-right">
    <button id="btnadjust" class="btn btn-info btn-xs hidden" onclick="showAdjust();"><?php echo \__('Adjust Time', 'eve-online-time-zones'); ?></button>
    <button id="btnclear" class="btn btn-danger btn-xs hidden" onclick="window.location.hash = '';"><?php echo \__('Remove', 'eve-online-time-zones'); ?></button>
    <button id="btnshowcurrent" class="btn btn-primary btn-xs hidden" onclick="switchto(0);"><?php echo \__('Switch to Current Time', 'eve-online-time-zones'); ?></button>
    <button id="btnshowfixed" class="btn btn-primary btn-xs hidden" onclick="switchto(1);"><?php echo \__('Switch to Timestamp', 'eve-online-time-zones'); ?></button>
</p>

<div id="adjust" class="hidden eve-online-time-zones-time-adjust">
    <hr>
    <span class="pull-right text-right">
        <form class="form-inline">
            <div class="form-group">
                <label>in</label>
                <div class="input-group input-group-sm">
                    <select class="form-control" id="tind">
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                    </select>
                    <div class="input-group-addon"><?php echo \__('Days', 'eve-online-time-zones'); ?></div>
                </div>

                <div class="input-group input-group-sm">
                    <select class="form-control" id="tinh">
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                    </select>
                    <div class="input-group-addon"><?php echo \__('Hours', 'eve-online-time-zones'); ?></div>
                </div>

                <div class="input-group input-group-sm">
                    <select class="form-control" id="tinm">
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                        <option>32</option>
                        <option>33</option>
                        <option>34</option>
                        <option>35</option>
                        <option>36</option>
                        <option>37</option>
                        <option>38</option>
                        <option>39</option>
                        <option>40</option>
                        <option>41</option>
                        <option>42</option>
                        <option>43</option>
                        <option>44</option>
                        <option>45</option>
                        <option>46</option>
                        <option>47</option>
                        <option>48</option>
                        <option>49</option>
                        <option>50</option>
                        <option>51</option>
                        <option>52</option>
                        <option>53</option>
                        <option>54</option>
                        <option>55</option>
                        <option>56</option>
                        <option>57</option>
                        <option>58</option>
                        <option>59</option>
                    </select>
                    <div class="input-group-addon"><?php echo \__('Minutes', 'eve-online-time-zones'); ?></div>
                </div>
                <button class="btn btn-info btn-sm" onclick="window.location.hash = (parseInt(new Date().getTime() / 1000) + jQuery('#tind').val() * 24 * 60 * 60 + jQuery('#tinh').val() * 60 * 60 + jQuery('#tinm').val() * 60);"><?php echo \__('Set Time', 'eve-online-time-zones'); ?></button>
            </div>
        </form>

        <form class="form-inline">
            <div class="form-group">
                <label>at</label>
                <div class="input-group input-group-sm">
                    <select class="form-control" id="tathour">
                        <option>00</option>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                    </select>
                    <div class="input-group-addon">:</div>
                    <select class="form-control" id="tatminute">
                        <option>00</option>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                        <option>32</option>
                        <option>33</option>
                        <option>34</option>
                        <option>35</option>
                        <option>36</option>
                        <option>37</option>
                        <option>38</option>
                        <option>39</option>
                        <option>40</option>
                        <option>41</option>
                        <option>42</option>
                        <option>43</option>
                        <option>44</option>
                        <option>45</option>
                        <option>46</option>
                        <option>47</option>
                        <option>48</option>
                        <option>49</option>
                        <option>50</option>
                        <option>51</option>
                        <option>52</option>
                        <option>53</option>
                        <option>54</option>
                        <option>55</option>
                        <option>56</option>
                        <option>57</option>
                        <option>58</option>
                        <option>59</option>
                    </select>
                </div>

                <div class="input-group input-group-sm">
                    <select class="form-control" id="tatzone">
                        <option value="Etc/UTC" selected><?php echo \__('EVE Time', 'eve-online-time-zones'); ?></option>
                        <option value=""><?php echo \__('Local Time', 'eve-online-time-zones'); ?></option>
                        <option value="US/Pacific"><?php echo \__('US Pacific', 'eve-online-time-zones'); ?></option>
                        <option value="US/Mountain"><?php echo \__('US Mountain', 'eve-online-time-zones'); ?></option>
                        <option value="US/Central"><?php echo \__('US Central', 'eve-online-time-zones'); ?></option>
                        <option value="US/Eastern"><?php echo \__('US Eastern', 'eve-online-time-zones'); ?></option>
                        <option value="Europe/London"><?php echo \__('EU Western / England', 'eve-online-time-zones'); ?></option>
                        <option value="Europe/Berlin"><?php echo \__('EU Central / Berlin', 'eve-online-time-zones'); ?></option>
                        <option value="Europe/Istanbul"><?php echo \__('EU Eastern / Turkey', 'eve-online-time-zones'); ?></option>
                        <option value="Europe/Moscow"><?php echo \__('Russia / Moscow', 'eve-online-time-zones'); ?></option>
                        <option value="Asia/Shanghai"><?php echo \__('China / Shanghai', 'eve-online-time-zones'); ?></option>
                        <option value="Australia/ACT"><?php echo \__('Australia / Sydney', 'eve-online-time-zones'); ?></option>
                    </select>
                </div>

                <div class="input-group input-group-sm">
                    <select class="form-control" id="tatyear">
                    </select>
                    <div class="input-group-addon">-</div>
                    <select class="form-control" id="tatmonth">
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select>
                    <div class="input-group-addon">-</div>
                    <select class="form-control" id="tatday">
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                    </select>
                </div>
                <button class="btn btn-info btn-sm" onclick="setdate(jQuery('#tatyear').val() + '-' + jQuery('#tatmonth').val() + '-' + jQuery('#tatday').val() + ' ' + jQuery('#tathour').val() + ':' + jQuery('#tatminute').val(), jQuery('#tatzone').val());"><?php echo \__('Set Time', 'eve-online-time-zones'); ?></button>
            </div>
        </form>
    </span>
</div>
