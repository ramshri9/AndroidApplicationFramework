<html>
<head>
	<script type="text/javascript">		
		
		/*
		* Function used to create XML for all the controls and populate in txtXML.
		*/
		var main_xml;
		function addText()
		{
			//Variables decalaration
			var applicationTitle, screenTitle, selectedControls,controlName,controlType,controlValue, xmlText,typeface,typesize,styleText,adminuser,adminspass;
			
			//Assign values
			applicationTitle = document.getElementById("txtApplicationName").value;
			screenTitle = document.getElementById("txtScreenName").value;
			selectedControls = document.getElementById("txtXml").value;
			selectedStyle = document.getElementById("stylexml").value;		
			controlName = document.getElementById("controlName").value;	
			controlType = document.getElementById("controlType").value; 	
			controlValue = document.getElementById("controlValue").value;	
			typeface     = document.getElementById("FontFace").value;
			typesize     = document.getElementById("TypeSize").value;
			color        = document.getElementById("Color").value;
			
			//Framing xml	
			xmlText   =  "\<\?xml version=\"1.0\" encoding=\"UTF-8\"\?\>\<fields\>";
			styleText = "\<resources xmlns\:android=\"http://schemas.android.com/apk/res/android\">";
			
			//Application Name
			xmlText = xmlText + "<application_name>"+applicationTitle+"</application_name>";
			
			//Screen Name
			xmlText = xmlText + "<screen_name>"+applicationTitle+"</screen_name>";
			styleText = styleText + "\<style name=\"AppTheme\" parent=\"AppBaseTheme\">";
			
			if ( selectedControls.length > 0 )
			{						
				xmlText = selectedControls.replace("</fields>","") + "\n" + getXml(controlName,controlType,controlValue);
			}
			else
			{
				xmlText = xmlText + getXml(controlName,controlType,controlValue);
			}			
			xmlText = xmlText + "</fields>";
			//if(document.getElementById("radadmin").checked)
			//{
				//adminuser = document.getElementById("adminuser").value;
				//adminpass = document.getElementById("adminpass").value;
			    //xmlText = xmlText + "<admincredentials>";
			    //xmlText = xmlText + "<username>"+adminuser+"</username>";
			    //xmlText = xmlText + "<password>"+adminpass+"</password>";
			    //xmlText = xmlText + "</admincredentials>";
			//}
			//else
			//{
				
			//}
			
			document.getElementById("txtXml").innerHTML = xmlText;
			main_xml = xmlText;
			
			styleText = styleText + "\<item name=\"android:typeface\">" + typeface + "</item>";
			styleText = styleText + "\<item name=\"android:textSize\">" + typesize + "</item>";
			styleText = styleText + "\<item name=\"android:textColor\">" + color + "</item>";
			styleText = styleText + "</style>";
			styleText = styleText + "</resources>";
			
			document.getElementById("stylexml").innerHTML = styleText;
			
			//Clear the content of the control
			document.getElementById("controlName").value = "";
			document.getElementById("controlType").selectedIndex = 0;
			document.getElementById("controlValue").value = "";
		}
		
		/*
		* Function used to show or hide the controlValue based upon the control type
		* Usually control values parameter is required only for Drop down, Radio Button and Checkbox
		*/
		function visibleControl(sel)
		{
			var controlType = sel.options[sel.selectedIndex].value;  
			if ( controlType == "spinner" || controlType == "radiobutton" || controlType == "checkbox" )
			{						
				document.getElementById("controlValue").style.display = "block";				
			}
			else
			{
				document.getElementById("controlValue").style.display = "none";	
			}
		}
		
		function displaytext()
		{
			//var AdminValue = document.getElementById("radadmin").value;
			if(document.getElementById("radadmin").checked)
			{
				document.getElementById("adminuser").disabled= false;
				document.getElementById("adminpass").disabled= false;
				
				document.getElementById("adminuser").style.visibility = "visible";
				document.getElementById("adminpass").style.visibility = "visible";				
			}
			else
			{
				//document.getElementById("adminuser").value= '';
				//document.getElementById("adminpass").value= '';
				
				document.getElementById("adminuser").disabled= true;
				document.getElementById("adminpass").disabled= true;
				
				document.getElementById("adminuser").style.visibility = "hidden";
				document.getElementById("adminpass").style.visibility = "hidden";
			}
		}
		
		/*
		* Function used to ammend the | symbol when press enter key
		*/
		function fKeyDown(e) 
		{
			var  kc = window.event ? window.event.keyCode : e.which;
			if (kc == 13) 
			{
				document.getElementById('controlValue').value = document.getElementById('controlValue').value + "|";
			} 
		}
		
		/*
		* Function used to get the XML based upon each control add
		*/
		function getXml(controlName, controlType, controlValue)
		{
			var xmlText = "<field><fieldname>" + controlName + "</fieldname>";			
			xmlText = xmlText + "<fieldtype>" + controlType +"</fieldtype>";			
			if (controlValue.length > 0 )
			{				
				var controlValues = controlValue.split("|");
				if (controlValues.length > 0 )
				{
					xmlText = xmlText + "<values>";						
					for (var index=0,len=controlValues.length; index<len; index++)
					{
						
						xmlText = xmlText + "<fieldvalue"+index+">"+ controlValues[index] +"</fieldvalue"+index+">";
					}				
					xmlText = xmlText + "</values>";	
				}			
			}
			xmlText=xmlText + "</field>";
			return xmlText;
		}
		
		function loadcontrols()
		{
				document.getElementById("adminuser").style.visibility = "hidden";
				document.getElementById("adminpass").style.visibility = "hidden";
		}
		function checkadmin()
		{
			var adminuser,adminpass;
			if(document.getElementById("radadmin").checked)
			{
				adminuser = document.getElementById("adminuser").value;
				adminpass = document.getElementById("adminpass").value;
			    main_xml = main_xml + "<admincredentials>";
			    main_xml = main_xml + "<username>"+adminuser+"</username>";
			    main_xml = main_xml + "<password>"+adminpass+"</password>";
			    main_xml = main_xml + "</admincredentials>";
			    document.getElementById("txtXml").innerHTML = main_xml;	
			}
			
					
		}
		
		
	</script>	
</head>
<body onload="loadcontrols();">
	<div  style="background-color:lightgrey"><h2 align="center">Android Application Framework</h2></div>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
		<table>
			<tr>
				<td>Application Name</td>
				<td><input type="text" name="txtApplicationName" id="txtApplicationName"/></td>
				<td><input type="checkbox" name="adminval" id="radadmin" onchange="displaytext();"/>Admin  </td>
				<td><input type="text" name="username" id="adminuser" value="username"/> </td>
				<td><input type="password" name="adminpassword" id="adminpass" value="password"/> </td>
			</tr>
			<tr>
				<td>Screen Name</td><td><input type="text" name="txtScreenName" id="txtScreenName"/></td>
			</tr>
			<tr border><td>Field Name</td><td><input type="text" name="controlName" id="controlName"></td>
			<td>
				Field Type : 
				<select name="controlType" id="controlType" onchange="visibleControl(this);">
				  <option value="normaltext">Normal Text Box</option>
				  <option value="numbertext">Number</option>
				  <option value="radiobutton">Radio Button</option>
				  <option value="datepicker">Date Picker</option>
				  <option value="spinner">Drop Down</option>
				  <option value="checkbox">Check Box</option>				 
				  <option value="phonetext">Phone</option>
				  <option value="multilinetext">Multiline Text</option>
				  <option value="passwordtext">Password Text</option>	
				  <option value="emailtext">Email</option>		
				  <option value="uritext">Web URL</option>
				</select>	
			</td>
			<td>
				TypeFace :
				<select name="FontFace" id="FontFace" onchange="visibleControl(this);">
					<option value="monospace">monospace</option>
					<option value="serif">serif</option>
				</select>
			</td>
			<td>
				TypeSize :
				<select name="TypeSize" id="TypeSize" onchange="visibleControl(this);">
					<option value="10pt">08pt</option>
					<option value="10pt">09pt</option>
					<option value="10pt">10pt</option>
					<option value="10pt">11pt</option>
					<option value="12pt">12pt</option>
					<option value="15pt">13pt</option>
					<option value="15pt">14pt</option>
					<option value="15pt">15pt</option>
				</select>
			</td>
			<td>
				Color :
				<select name="Color" id="Color" onchange="visibleControl(this);">
					<option  value="#FFFFFF">#FFFFFF</option >
					<option  value="#FFFF00">#FFFF00</option >
					<option  value="#FF00FF">#FF00FF</option >
					<option  value="#FF0000">#FF0000</option >
					<option  value="#C0C0C0">#C0C0C0</option >
					<option  value="#808080">#808080</option >
					<option  value="#808000">#808000</option >
					<option  value="#800080">#800080</option >
					<option  value="#800000">#800000</option >
					<option  value="#00FFFF">#00FFFF</option >
					<option  value="#00FF00">#00FF00</option >
					<option  value="#008080">#008080</option >
					<option  value="#008000">#008000</option >
					<option  value="#0000FF">#0000FF</option >
					<option  value="#000080">#000080</option >
					<option  value="#000000">#000000</option >
				</select>
			</td>
			<td>
				<textarea name="controlValue" id="controlValue" rows="5" cols="30" style="display:none" onKeyDown=javascript:fKeyDown(event);></textarea>
			</td>
			<td><input type="button" onclick="addText();" name="btnAdd" value="Add" width="100"/></td>
			</tr>
			<tr>
				<td>Fields XML </td><td colspan="6" align="left"><textarea name="txtXml" id="txtXml" rows="5" cols="100"></textarea>
				</td>
			</tr>
			<tr>
				<td>Style XML </td><td colspan="6" align="left"><textarea name="stylexml" id="stylexml" rows="5" cols="100"></textarea>
				</td>
			</tr>
			<tr></tr>
			
			</table>
			<div align="center"><input type="submit" name="submit" value="Generate" align="center" onclick="checkadmin();"></div>			
			<p style="background-color:lightgrey" align="center">
			<?php
				if(isset($_POST['submit']))
				{
					$txtXml  = $_POST['txtXml'];	
				    $var = file_put_contents("/var/www/dynamic_fields_admin.xml",$txtXml);	
					$stylexml = $_POST['stylexml'];
					$var1 = file_put_contents("/var/www/styles.xml",$stylexml);
					echo $var;
					echo "dynamic_fields.xml has been generated successfully";		
				}	
			?>
			</p>			
		</form>
	</body>
</html>
