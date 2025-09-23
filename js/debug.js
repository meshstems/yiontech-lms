// Debug script to identify elements causing horizontal lines
document.addEventListener('DOMContentLoaded', function() {
    console.log("Debug script loaded");
    
    // Check for elements with borders
    const allElements = document.querySelectorAll('*');
    const elementsWithBorders = [];
    
    allElements.forEach(element => {
        const styles = window.getComputedStyle(element);
        if (styles.borderTopWidth !== '0px' || 
            styles.borderBottomWidth !== '0px' || 
            styles.borderLeftWidth !== '0px' || 
            styles.borderRightWidth !== '0px') {
            elementsWithBorders.push({
                element: element,
                tagName: element.tagName,
                classes: element.className,
                id: element.id,
                borderTop: styles.borderTopWidth,
                borderBottom: styles.borderBottomWidth,
                borderLeft: styles.borderLeftWidth,
                borderRight: styles.borderRightWidth
            });
        }
    });
    
    if (elementsWithBorders.length > 0) {
        console.log("Elements with borders:", elementsWithBorders);
    } else {
        console.log("No elements with borders found");
    }
    
    // Check for hr elements
    const hrElements = document.querySelectorAll('hr');
    if (hrElements.length > 0) {
        console.log("HR elements found:", hrElements);
    } else {
        console.log("No HR elements found");
    }
    
    // Check for elements with box-shadow
    const elementsWithShadow = [];
    allElements.forEach(element => {
        const styles = window.getComputedStyle(element);
        if (styles.boxShadow !== 'none') {
            elementsWithShadow.push({
                element: element,
                tagName: element.tagName,
                classes: element.className,
                id: element.id,
                boxShadow: styles.boxShadow
            });
        }
    });
    
    if (elementsWithShadow.length > 0) {
        console.log("Elements with box-shadow:", elementsWithShadow);
    } else {
        console.log("No elements with box-shadow found");
    }
});