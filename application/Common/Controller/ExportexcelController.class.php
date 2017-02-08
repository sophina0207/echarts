<?php
/**
 * @author:wangying
 * @creat:2016年8月10日
 * @desc:
 */
namespace Common\Controller;

class ExportexcelController 
{
	protected $sheet;
	public function __construct($file_name,$arr,$head=array())
	{
		vendor('PHPExcel.PHPExcel');
		$phpexcel = new \PHPExcel();
		$sheet=$phpexcel->getActiveSheet();
		$this->sheet=$sheet;
		$sheet->setTitle($file_name);
		$flag=false;
		
		if($head)
		{//表格的头部
			$flag=true;
			foreach ($head as $key => $title)
			{
				//添加head记录
				$sheet->setCellValueByColumnAndRow($key,1,$title);
				$this->setStyle($key, 1,true);
			}
		}
		foreach ($arr as $key =>$item)
		{
			$colum=0;
			foreach ($item as $k =>$v )
			{
				if(!$flag && $key == 0)
				{
					//添加head记录
					$sheet->setCellValueByColumnAndRow($colum,$key+1,$k);
					$this->setStyle($colum, $key+1,true);
				}
				//添加每行记录
				$sheet->setCellValueByColumnAndRow($colum,$key+2,$v);
				$this->setStyle($colum, $key+2);
				$colum++;
			}
		}
		//设置head的行高
		$sheet->getRowDimension(1)->setRowHeight(30);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xls"');
		header('Cache-Control: max-age=0');
		\PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5')->save('php://output');
	
	}
	
	protected function setStyle($colum,$row,$head=false)
	{
		$sheet=$this->sheet;
		$style=$sheet->getStyleByColumnAndRow($colum,$row);
		if($head)
		{
			//设置字体
			$style->getFont()->setBold(true)
							 ->setSize(14);
		}else
		{
			//设置字体
			$style->getFont()->setSize(12);
		}
		//设置列宽自适应
		$sheet->getColumnDimensionByColumn($colum)->setAutoSize(true);
		//设置边框
		$objBorder=$style->getBorders();
		$objBorder->getAllBorders()->getColor()->setRGB('000000');
		$objBorder->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
		//设置对齐方式--上下居中
		$style->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	}
}