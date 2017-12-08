<p class="text-right">
	<button id="btnadjust" class="btn btn-info btn-xs hidden" onclick="showAdjust();">Adjust Time</button>
	<button id="btnclear" class="btn btn-danger btn-xs hidden" onclick="window.location.hash = '';">Remove</button>
	<button id="btnshowcurrent" class="btn btn-primary btn-xs hidden" onclick="switchto(0);">Switch to Current Time</button>
	<button id="btnshowfixed" class="btn btn-primary btn-xs hidden" onclick="switchto(1);">Switch to Timestamp</button>
</p>

<div id="adjust" class="hidden">
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
					<div class="input-group-addon">days</div>
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
					<div class="input-group-addon">hours</div>
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
					<div class="input-group-addon">minutes</div>
				</div>
				<button class="btn btn-info btn-sm" onclick="window.location.hash = (parseInt(new Date().getTime() / 1000) + jQuery('#tind').val() * 24 * 60 * 60 + jQuery('#tinh').val() * 60 * 60 + jQuery('#tinm').val() * 60);">Set Time</button>
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
						<option value="Etc/UTC" selected>EVE Time</option>
						<option value="">Local</option>
						<option value="US/Pacific">US Pacific</option>
						<option value="US/Mountain">US Mountain</option>
						<option value="US/Central">US Central</option>
						<option value="US/Eastern">US Eastern</option>
						<option value="Europe/London">EU Western / England</option>
						<option value="Europe/Berlin">EU Central / Berlin</option>
						<option value="Europe/Istanbul">EU Eastern / Turkey</option>
						<option value="Europe/Moscow">Russia / Moscow</option>
						<option value="Asia/Shanghai">China / Shanghai</option>
						<option value="Australia/ACT">Australia / Sydney</option>
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
				<button class="btn btn-info btn-sm" onclick="setdate(jQuery('#tatyear').val() + '-' + jQuery('#tatmonth').val() + '-' + jQuery('#tatday').val() + ' ' + jQuery('#tathour').val() + ':' + jQuery('#tatminute').val(), jQuery('#tatzone').val());">Set Time</button>
			</div>
		</form>
	</span>
</div>