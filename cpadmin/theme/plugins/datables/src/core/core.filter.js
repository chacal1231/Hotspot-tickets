

/**
 * Generate the node required for filtering text
 *  @returns {node} Filter control element
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnFeatureHtmlFilter ( oSettings )
{
	var oPreviousBuscar = oSettings.oPreviousBuscar;
	
	var sBuscarStr = oSettings.oLanguage.sBuscar;
	sBuscarStr = (sBuscarStr.indexOf('_INPUT_') !== -1) ?
	  sBuscarStr.replace('_INPUT_', '<input type="text" />') :
	  sBuscarStr==="" ? '<input type="text" />' : sBuscarStr+' <input type="text" />';
	
	var nFilter = document.createElement( 'div' );
	nFilter.className = oSettings.oClasses.sFilter;
	nFilter.innerHTML = '<label>'+sBuscarStr+'</label>';
	if ( !oSettings.aanFeatures.f )
	{
		nFilter.id = oSettings.sTableId+'_filter';
	}
	
	var jqFilter = $("input", nFilter);
	jqFilter.val( oPreviousBuscar.sBuscar.replace('"','&quot;') );
	jqFilter.bind( 'keyup.DT', function(e) {
		/* Update all other filter input elements for the new display */
		var n = oSettings.aanFeatures.f;
		for ( var i=0, iLen=n.length ; i<iLen ; i++ )
		{
			if ( n[i] != $(this).parents('div.dataTables_filter')[0] )
			{
				$('input', n[i]).val( this.value );
			}
		}
		
		/* Now do the filter */
		if ( this.value != oPreviousBuscar.sBuscar )
		{
			_fnFilterComplete( oSettings, { 
				"sBuscar": this.value, 
				"bRegex": oPreviousBuscar.bRegex,
				"bSmart": oPreviousBuscar.bSmart ,
				"bCaseInsensitive": oPreviousBuscar.bCaseInsensitive 
			} );
		}
	} );

	jqFilter
		.attr('aria-controls', oSettings.sTableId)
		.bind( 'keypress.DT', function(e) {
			/* Prevent form submission */
			if ( e.keyCode == 13 )
			{
				return false;
			}
		}
	);
	
	return nFilter;
}


/**
 * Filter the table using both the global filter and column based filtering
 *  @param {object} oSettings dataTables settings object
 *  @param {object} oBuscar search information
 *  @param {int} [iForce] force a research of the master array (1) or not (undefined or 0)
 *  @memberof DataTable#oApi
 */
function _fnFilterComplete ( oSettings, oInput, iForce )
{
	var oPrevBuscar = oSettings.oPreviousBuscar;
	var aoPrevBuscar = oSettings.aoPreBuscarCols;
	var fnSaveFilter = function ( oFilter ) {
		/* Save the filtering values */
		oPrevBuscar.sBuscar = oFilter.sBuscar;
		oPrevBuscar.bRegex = oFilter.bRegex;
		oPrevBuscar.bSmart = oFilter.bSmart;
		oPrevBuscar.bCaseInsensitive = oFilter.bCaseInsensitive;
	};

	/* In server-side processing all filtering is done by the server, so no point hanging around here */
	if ( !oSettings.oFeatures.bServerSide )
	{
		/* Global filter */
		_fnFilter( oSettings, oInput.sBuscar, iForce, oInput.bRegex, oInput.bSmart, oInput.bCaseInsensitive );
		fnSaveFilter( oInput );

		/* Now do the individual column filter */
		for ( var i=0 ; i<oSettings.aoPreBuscarCols.length ; i++ )
		{
			_fnFilterColumn( oSettings, aoPrevBuscar[i].sBuscar, i, aoPrevBuscar[i].bRegex, 
				aoPrevBuscar[i].bSmart, aoPrevBuscar[i].bCaseInsensitive );
		}
		
		/* Custom filtering */
		_fnFilterCustom( oSettings );
	}
	else
	{
		fnSaveFilter( oInput );
	}
	
	/* Tell the draw function we have been filtering */
	oSettings.bFiltered = true;
	$(oSettings.oInstance).trigger('filter', oSettings);
	
	/* Redraw the table */
	oSettings._iDisplayStart = 0;
	_fnCalculateEnd( oSettings );
	_fnDraw( oSettings );
	
	/* Rebuild search array 'offline' */
	_fnBuildBuscarArray( oSettings, 0 );
}


/**
 * Apply custom filtering functions
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnFilterCustom( oSettings )
{
	var afnFilters = DataTable.ext.afnFiltering;
	for ( var i=0, iLen=afnFilters.length ; i<iLen ; i++ )
	{
		var iCorrector = 0;
		for ( var j=0, jLen=oSettings.aiDisplay.length ; j<jLen ; j++ )
		{
			var iDisIndex = oSettings.aiDisplay[j-iCorrector];
			
			/* Check if we should use this row based on the filtering function */
			if ( !afnFilters[i]( oSettings, _fnGetRowData( oSettings, iDisIndex, 'filter' ), iDisIndex ) )
			{
				oSettings.aiDisplay.splice( j-iCorrector, 1 );
				iCorrector++;
			}
		}
	}
}


/**
 * Filter the table on a per-column basis
 *  @param {object} oSettings dataTables settings object
 *  @param {string} sInput string to filter on
 *  @param {int} iColumn column to filter
 *  @param {bool} bRegex treat search string as a regular expression or not
 *  @param {bool} bSmart use smart filtering or not
 *  @param {bool} bCaseInsensitive Do case insenstive matching or not
 *  @memberof DataTable#oApi
 */
function _fnFilterColumn ( oSettings, sInput, iColumn, bRegex, bSmart, bCaseInsensitive )
{
	if ( sInput === "" )
	{
		return;
	}
	
	var iIndexCorrector = 0;
	var rpBuscar = _fnFilterCreateBuscar( sInput, bRegex, bSmart, bCaseInsensitive );
	
	for ( var i=oSettings.aiDisplay.length-1 ; i>=0 ; i-- )
	{
		var sData = _fnDataToBuscar( _fnGetCellData( oSettings, oSettings.aiDisplay[i], iColumn, 'filter' ),
			oSettings.aoColumns[iColumn].sType );
		if ( ! rpBuscar.test( sData ) )
		{
			oSettings.aiDisplay.splice( i, 1 );
			iIndexCorrector++;
		}
	}
}


/**
 * Filter the data table based on user input and draw the table
 *  @param {object} oSettings dataTables settings object
 *  @param {string} sInput string to filter on
 *  @param {int} iForce optional - force a research of the master array (1) or not (undefined or 0)
 *  @param {bool} bRegex treat as a regular expression or not
 *  @param {bool} bSmart perform smart filtering or not
 *  @param {bool} bCaseInsensitive Do case insenstive matching or not
 *  @memberof DataTable#oApi
 */
function _fnFilter( oSettings, sInput, iForce, bRegex, bSmart, bCaseInsensitive )
{
	var i;
	var rpBuscar = _fnFilterCreateBuscar( sInput, bRegex, bSmart, bCaseInsensitive );
	var oPrevBuscar = oSettings.oPreviousBuscar;
	
	/* Check if we are forcing or not - optional parameter */
	if ( !iForce )
	{
		iForce = 0;
	}
	
	/* Need to take account of custom filtering functions - always filter */
	if ( DataTable.ext.afnFiltering.length !== 0 )
	{
		iForce = 1;
	}
	
	/*
	 * If the input is blank - we want the full data set
	 */
	if ( sInput.length <= 0 )
	{
		oSettings.aiDisplay.splice( 0, oSettings.aiDisplay.length);
		oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
	}
	else
	{
		/*
		 * We are starting a new search or the new search string is smaller 
		 * then the old one (i.e. delete). Buscar from the master array
	 	 */
		if ( oSettings.aiDisplay.length == oSettings.aiDisplayMaster.length ||
			   oPrevBuscar.sBuscar.length > sInput.length || iForce == 1 ||
			   sInput.indexOf(oPrevBuscar.sBuscar) !== 0 )
		{
			/* Nuke the old display array - we are going to rebuild it */
			oSettings.aiDisplay.splice( 0, oSettings.aiDisplay.length);
			
			/* Force a rebuild of the search array */
			_fnBuildBuscarArray( oSettings, 1 );
			
			/* Buscar through all records to populate the search array
			 * The the oSettings.aiDisplayMaster and asDataBuscar arrays have 1 to 1 
			 * mapping
			 */
			for ( i=0 ; i<oSettings.aiDisplayMaster.length ; i++ )
			{
				if ( rpBuscar.test(oSettings.asDataBuscar[i]) )
				{
					oSettings.aiDisplay.push( oSettings.aiDisplayMaster[i] );
				}
			}
	  }
	  else
		{
	  	/* Using old search array - refine it - do it this way for speed
	  	 * Don't have to search the whole master array again
			 */
	  	var iIndexCorrector = 0;
	  	
	  	/* Buscar the current results */
	  	for ( i=0 ; i<oSettings.asDataBuscar.length ; i++ )
			{
	  		if ( ! rpBuscar.test(oSettings.asDataBuscar[i]) )
				{
	  			oSettings.aiDisplay.splice( i-iIndexCorrector, 1 );
	  			iIndexCorrector++;
	  		}
	  	}
	  }
	}
}


/**
 * Create an array which can be quickly search through
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iMaster use the master data array - optional
 *  @memberof DataTable#oApi
 */
function _fnBuildBuscarArray ( oSettings, iMaster )
{
	if ( !oSettings.oFeatures.bServerSide )
	{
		/* Clear out the old data */
		oSettings.asDataBuscar.splice( 0, oSettings.asDataBuscar.length );
		
		var aArray = (iMaster && iMaster===1) ?
		 	oSettings.aiDisplayMaster : oSettings.aiDisplay;
		
		for ( var i=0, iLen=aArray.length ; i<iLen ; i++ )
		{
			oSettings.asDataBuscar[i] = _fnBuildBuscarRow( oSettings,
				_fnGetRowData( oSettings, aArray[i], 'filter' ) );
		}
	}
}


/**
 * Create a searchable string from a single data row
 *  @param {object} oSettings dataTables settings object
 *  @param {array} aData Row data array to use for the data to search
 *  @memberof DataTable#oApi
 */
function _fnBuildBuscarRow( oSettings, aData )
{
	var sBuscar = '';
	if ( oSettings.__nTmpFilter === undefined )
	{
		oSettings.__nTmpFilter = document.createElement('div');
	}
	var nTmp = oSettings.__nTmpFilter;
	
	for ( var j=0, jLen=oSettings.aoColumns.length ; j<jLen ; j++ )
	{
		if ( oSettings.aoColumns[j].bBuscarable )
		{
			var sData = aData[j];
			sBuscar += _fnDataToBuscar( sData, oSettings.aoColumns[j].sType )+'  ';
		}
	}
	
	/* If it looks like there is an HTML entity in the string, attempt to decode it */
	if ( sBuscar.indexOf('&') !== -1 )
	{
		nTmp.innerHTML = sBuscar;
		sBuscar = nTmp.textContent ? nTmp.textContent : nTmp.innerText;
		
		/* IE and Opera appear to put an newline where there is a <br> tag - remove it */
		sBuscar = sBuscar.replace(/\n/g," ").replace(/\r/g,"");
	}
	
	return sBuscar;
}

/**
 * Build a regular expression object suitable for searching a table
 *  @param {string} sBuscar string to search for
 *  @param {bool} bRegex treat as a regular expression or not
 *  @param {bool} bSmart perform smart filtering or not
 *  @param {bool} bCaseInsensitive Do case insenstive matching or not
 *  @returns {RegExp} constructed object
 *  @memberof DataTable#oApi
 */
function _fnFilterCreateBuscar( sBuscar, bRegex, bSmart, bCaseInsensitive )
{
	var asBuscar, sRegExpString;
	
	if ( bSmart )
	{
		/* Generate the regular expression to use. Something along the lines of:
		 * ^(?=.*?\bone\b)(?=.*?\btwo\b)(?=.*?\bthree\b).*$
		 */
		asBuscar = bRegex ? sBuscar.split( ' ' ) : _fnEscapeRegex( sBuscar ).split( ' ' );
		sRegExpString = '^(?=.*?'+asBuscar.join( ')(?=.*?' )+').*$';
		return new RegExp( sRegExpString, bCaseInsensitive ? "i" : "" );
	}
	else
	{
		sBuscar = bRegex ? sBuscar : _fnEscapeRegex( sBuscar );
		return new RegExp( sBuscar, bCaseInsensitive ? "i" : "" );
	}
}


/**
 * Convert raw data into something that the user can search on
 *  @param {string} sData data to be modified
 *  @param {string} sType data type
 *  @returns {string} search string
 *  @memberof DataTable#oApi
 */
function _fnDataToBuscar ( sData, sType )
{
	if ( typeof DataTable.ext.ofnBuscar[sType] === "function" )
	{
		return DataTable.ext.ofnBuscar[sType]( sData );
	}
	else if ( sType == "html" )
	{
		return sData.replace(/[\r\n]/g," ").replace( /<.*?>/g, "" );
	}
	else if ( typeof sData === "string" )
	{
		return sData.replace(/[\r\n]/g," ");
	}
	else if ( sData === null )
	{
		return '';
	}
	return sData;
}


/**
 * scape a string stuch that it can be used in a regular expression
 *  @param {string} sVal string to escape
 *  @returns {string} escaped string
 *  @memberof DataTable#oApi
 */
function _fnEscapeRegex ( sVal )
{
	var acEscape = [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^' ];
	var reReplace = new RegExp( '(\\' + acEscape.join('|\\') + ')', 'g' );
	return sVal.replace(reReplace, '\\$1');
}

