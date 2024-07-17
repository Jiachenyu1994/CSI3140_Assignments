# 1D Paku Paku Game Visual Design System

## Structural / Recurring Components

### Header
- *Class*: `header`
- *Position*: Fixed at the top of the page.
- *Width*: 100%
- *Background*: Black with rgba overlay (rgba(0, 12, 1, 0.589)).
- *Backdrop Filter*: Blur effect (5px).
- *Padding*: 33px 10%.
- *Flexbox*: Used for centering contents.
- *Z-Index*: 1000 (to keep it on top of other elements).

### Navigation Bar
- *Class*: `navigationbar`
- *Display*: Flexbox.
- *Align Items*: Center.
- *Navigation Links*:
  - *Font Size*: 40px.
  - *Color*: White.
  - *Font Weight*: Bold.
  - *Margin Left*: 20px.

### Logo
- *Class*: `logo`
- *Width*: 200px.

### Scoreboard
- *Class*: `scoreboard`
- *Dimensions*: 100px width, 50px height.
- *Line Height*: 50px (to center text vertically).
- *Font Size*: 24px.
- *Color*: White.
- *Background*: Black with rgba overlay (rgba(0, 0, 0, 0.5)).
- *Border*: 2px solid white.
- *Border Radius*: 10px.
- *Display*: Inline-block.
- *Margin*: 20px auto.

### Board (Play Area)
- *Class*: `board`
- *Font Size*: 50px.
- *Color*: White.
- *Background Color*: Black.
- *Padding*: 20px.
- *Border*: 2px solid white.
- *Border Radius*: 10px.
- *Display*: Flexbox.
- *Justify Content*: Center.
- *White Space*: Pre.

### Cells within the Board
- *Class*: `cell`
- *Dimensions*: 40px by 40px.
- *Display*: Flexbox.
- *Align Items*: Center.
- *Justify Content*: Center.

### Images within Cells
- *Selector*: `.board .cell img`
- *Width*: 100%.
- *Height*: 100%.

### Buttons
- *Selector*: `button`
- *Dimensions*: 300px width, 50px height.
- *Padding*: 10px.
- *Font Size*: 18px.
- *Border*: 1px solid #ccc.
- *Border Radius*: 5px.
- *Background Color*: Black.
- *Color*: White.
- *Cursor*: Pointer.
- *Hover State*: Background color changes to gray.

### Input Fields
- *Selector*: `input[type="number"]`
- *Dimensions*: 300px width, 50px height.
- *Padding*: 10px.
- *Font Size*: 18px.
- *Border*: 1px solid #ccc.
- *Border Radius*: 5px.
- *Box Sizing*: Border-box.

## Color Palette
- *Primary Background*: `black` with rgba overlay.
- *Text Color*: `white`.
- *Interactive Elements*: 
  - *Buttons*: `black` (default), `gray` (hover).
- *Game Elements*:
  - *Pacman*: Yellow (image).
  - *Ghost*: Red (image).
  - *Pellets*: White (image).
  - *Fruits*: Various (image).

## Fonts and Sizes
- *Font Family*: `sans-serif` (default for all elements).
- *Font Sizes*:
  - *Navigation Links*: 40px.
  - *Scoreboard Text*: 24px.
  - *Board Text*: 50px.
  - *Button Text*: 18px.
  - *Input Text*: 18px.

## Background
- *Body Background*:
  - *Image*: `photos/backgroundimage2.jpg`.
  - *Size*: Cover.
  - *Position*: Center.
  - *Attachment*: Fixed.

This design system outlines the main visual components and color choices.
