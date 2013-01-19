<?php

class Helper
{
	/*Sirve para cambiar más facilmente los factores de partido*/
	static $datos_factores = array (	
		//Si es local
		'local' => array (
			'ambiente'=> 'ambiente',
			'nivel'=> 'nivel_local',
			'aforo' => 'aforo_local',
			'moral' => 'moral_local',
			'ofensivo' => 'ofensivo_local',
			'defensivo' => 'defensivo_local'
		), 
		//Si es visitante
		'visitante' => array (
			'ambiente'=> 'ambiente',
			'nivel'=> 'nivel_visitante',
			'aforo' => 'aforo_visitante',
			'moral' => 'moral_visitante',
			'ofensivo' => 'ofensivo_visitante',
			'defensivo' => 'defensivo_visitante'
		), 
	);

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que aumentamos
	 * @devuelve flag de error
	 * @ejemplo	$h->aumentar_recursos(3, "animo", 30);
	 */
	public function aumentar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuarios::model()->findByPK($id_usuario);
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$valor_nuevo=$actuales + $cantidad;
				/*Debo comprobar que no esta o sobrepasa en su máximo el atributo*/

				/*En el caso del animo*/
				if( ($columna==='animo') && ($valor_nuevo >= $recursos->animo_max))
				{
					$recursos->$columna=$recursos->animo_max;

				}else if( ($columna==='influencias') && ($valor_nuevo >= $recursos->influencias_max))
						{
							$recursos->$columna=$recursos->influencias_max;

						}else 
							{
								$recursos->$columna=$valor_nuevo;
							}
				
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
		
	}

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro usuario al que modificamos sus recursos
	 * @parametro columna sobre la que modificamos (dinero, dinero_gen, ...)
	 * @parametro cantidad de recursos que quitamos
	 * @devuelve flag de error
	 * @ejemplo	$h->quitar_recursos(3, "animo", 30);
	 */
	public function quitar_recursos($id_usuario, $columna, $cantidad)
	{
		/* ROBER */
		/*Recupero el usuario del que voy a aumentar los recursos*/
		$usuario=Usuarios::model()->findByPK($id_usuario);
		/*Recupero de la tabla recursos la fila correspondiente a este usuario
		  Compruebo si hay una instancia para ese usuario, sino la hay es null y devuelvo error*/
		$recursos=$usuario->recursos;
		if($recursos === null)
		{
			return -1;
		}else
			{
				/*Cojo la columna a modificar del modelo, para modificarla despues*/
				$actuales=$recursos->$columna;
				$recursos->$columna=$actuales - $cantidad;
				/*Al restar debo de comprobar que no sea valor negativo*/
				if($recursos->$columna < 0)
				{
					$recursos->$columna=0;
				}
				/*Si save() no lanza error entonces se realizo correctamente la actualizacion
				 sino devuelves error*/
				if($recursos->save())
				{
					return 0;

				}else
					{
						return -1;
					}
			}
	} 

	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro partido en el que modificamos sus factores
	 * @paremetro equipo al que pertenece
	 * @parametro columna sobre la que modificamos (moral,ambiente,ind.ofensivo...)
	 * @parametro cantidad de recursos que aumentamos
	 * @devuelve flag de error
	 */
	public function aumentar_factores($id_partido,$id_equipo, $columna, $cantidad)
	{
		//Cojo el modelo correspondiente a ese id
		$partido=Partidos::model()->findByPK($id_partido);

		//Comrpuebo si juega de local o de visitante
		if($partido->equipos_id_equipo_1 == $id_equipo)
		{
			$factor=$datos_factores['local'][$columna];
			$valor_nuevo=$partido->$factor + $cantidad;
			//Si fallara tiene que ser por el $factor,comprobar si es asi 
			$partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
     		if($partido->save()) return 0; else return -1;

		}else if($partido->equipos_id_equipo_2 == $id_equipo)
				{
					$factor=$datos_factores['visitante'][$columna];
					$valor_nuevo=$partido->$factor + $cantidad;
					//Si fallara tiene que ser por el $factor,comprobar si es asi 
					$partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
		     		if($partido->save()) return 0; else return -1;
		     		
				}else
					{
						//Si ha llegado aqui por alguna cosa, es que no coincide con ninguno de 
						//los id de los equipo del partido
						return -1;
					}
	}
	/** Funcion auxiliar que modifica la tabla de recursos
	 * 
	 * @paremetro partido en el que modificamos sus factores
	 * @paremetro equipo al que pertenece
	 * @parametro columna sobre la que modificamos (moral,ambiente,ind.ofensivo...)
	 * @parametro cantidad de recursos que aumentamos
	 * @devuelve flag de error
	 */
	public function disminuir_factores($id_partido,$id_equipo, $columna, $cantidad)
	{
		//Cojo el modelo correspondiente a ese id
		$partido=Partidos::model()->findByPK($id_partido);

		//Comrpuebo si juega de local o de visitante
		if($partido->equipos_id_equipo_1 == $id_equipo)
		{
			$factor=$datos_factores['local'][$columna];
			$valor_nuevo=$partido->$factor - $cantidad;
			//Si fallara tiene que ser por el $factor,comprobar si es asi 
			$partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
     		if($partido->save()) return 0; else return -1;

		}else if($partido->equipos_id_equipo_2 == $id_equipo)
				{
					$factor=$datos_factores['visitante'][$columna];
					$valor_nuevo=$partido->$factor - $cantidad;
					//Si fallara tiene que ser por el $factor,comprobar si es asi 
					$partido->setAttributes(array(''.$factor.''=>$valor_nuevo));
		     		if($partido->save()) return 0; else return -1;
				}else
					{
						//Si ha llegado aqui por alguna cosa, es que no coincide con ninguno de 
						//los id de los equipo del partido
						return -1;
					}
	}
}

