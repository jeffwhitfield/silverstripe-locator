<div class="content-container unit size3of4 lastUnit">
	<h2>$Title</h2>
	<% if Content %><div class="typography">$Content</div><% end_if %>
	
	<div id="form-container">
	    <form id="user-location" method="post" action="#">
	        <div id="form-input">
	          	<div class="field">
		          	<label for="address">Enter Address or Zip Code:</label>
		          	<input type="text" id="address" name="address" />
	          	</div>
	          	<div class="field">
		          	<% if $FilterByCategory %>
			          	<label for="category">Filter by Category:</label>
			          	<select id="category" name="category">
			          		<option value="">All</option>
			          		<% loop AllCategories %>
			          			<option value="$Name.XML">$Name.XML</option>
			          		<% end_loop %>
			          	</select>	
		          	<% end_if %>
		        </div>
	         </div>
	        
	         <div id="submit-btn">
	         	<div class="field">
	         		<input type="image" id="submit" name="submit" src="/locator/images/submit.jpg" alt="Submit" />
	         	</div>
	         </div>
	    </form>
	</div>
	
	<div id="map-container">
		<div id="map"></div>
		<div id="loc-list">
	        <ul id="list"></ul>
	    </div>
	  </div>
	</div>
	
</div>

