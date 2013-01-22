'**************************************
' Name: Printing Text Files in DOS mode without any Text Editor
' Description:Printing Text files in DOS mode without any Text Editor
' By: Kazi Khalid
'
'This code is copyrighted and has' limited warranties.Please see http://www.Planet-Source-Code.com/vb/scripts/ShowCode.asp?txtCodeId=51448&lngWId=1'for details.'**************************************

'Call the Print_File function and pass it the filename to print.
Private Declare Function WritePrinter Lib "winspool.drv" _
(ByVal hPrinter As Long, _
pBuf As Any, _
ByVal cdBuf As Long, _
pcWritten As Long) As Long
Private Declare Function OpenPrinter Lib "winspool.drv" _
Alias "OpenPrinterA" _
(ByVal pPrinterName As String, _
phPrinter As Long, _
pDefault As Any) As Long
Private Declare Function ClosePrinter Lib "winspool.drv" _
(ByVal hPrinter As Long) As Long
Private Declare Function StartDocPrinter Lib "winspool.drv" _
Alias "StartDocPrinterA" _
(ByVal hPrinter As Long, _
ByVal Level As Long, _
pDocInfo As Byte) As Long
Private Declare Function EndDocPrinter Lib "winspool.drv" _
(ByVal hPrinter As Long) As Long
Private Sub Print_File(FName As String)
Dim StrToPrint As String
Dim LngPrinted As Long
Dim lhPrinter As Long
Dim PrntErr As Long
If (FName = "") Then
MsgBox "Nothing to print or File Empty", vbCritical, "Error"
Exit Sub
End If
PrntErr = OpenPrinter(Printer.DeviceName, lhPrinter, 0&)
If (PrntErr = 0) Then
MsgBox "Error in Printing ", vbCritical, "Error"
Exit Sub
End If
PrntErr = StartDocPrinter(lhPrinter, 1, 0&)
If (PrntErr = 0) Then
'Printer is Directly connected to the Machine
Call PrintToPort(FName)
Exit Sub
End If
Open FName For Input As #1
StrToPrint = ""
While Not EOF(1)
Line Input #1, StrToPrint
StrToPrint = StrToPrint + Chr(13) + Chr(10)
WritePrinter lhPrinter, ByVal StrToPrint, _
Len(StrToPrint), LngPrinted
Wend
EndDocPrinter lhPrinter
ClosePrinter lhPrinter
Close #1
End Sub
Private Sub PrintToPort(FName As String)
Open FName For Input As #1
Open "LPT1" For Output As #2
StrToPrint = ""
While Not EOF(1)
Line Input #1, StrToPrint
StrToPrint = StrToPrint
Print #2, StrToPrint
Wend
Close #2
Close #1
End Sub